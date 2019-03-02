<?php

namespace Kennziffer\KeQuestionnaire\Controller;

use Kennziffer\KeQuestionnaire\Domain\Model\Result;
use Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Kennziffer.com <info@kennziffer.com>, www.kennziffer.com
 *  (c) 2019 WapplerSystems <typo3YYYY@wappler.systems>, www.wappler.systems
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ResultController extends \Kennziffer\KeQuestionnaire\Controller\AbstractController
{

    /**
     * injectQuestionnaireRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionnaireRepository $questionnaireRepository
     * @return void
     */
    public function injectQuestionnaireRepository(
        \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionnaireRepository $questionnaireRepository
    ) {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    /**
     * initializes the actions
     */
    public function initializeAction()
    {
        parent::initializeAction();
        $this->questionnaire->settings = $this->settings;

        //check a logged in user
        $userRepository = $this->objectManager->get(FrontendUserRepository::class);
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $userRepository->setDefaultQuerySettings($querySettings);

        if ($GLOBALS['TSFE']->fe_user->user['uid']) {
            $this->user = $userRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        }

        //check jsKey for the created js-file
        $jsKey = substr($GLOBALS['TSFE']->fe_user->id, 0, 10) . '_keqjs';
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'keq_jskey', $jsKey);
        //maybe better to erase the js file every time
        $pathname = 'typo3temp/ke_questionnaire';
        $filename = $pathname . '/' . $jsKey . '.js';
        if (file_exists(PATH_site . $filename)) {
            unlink($filename);
        }
    }

    /**
     * Displays a form for saving a new questionnaire
     *
     * @param Result $newResult A fresh new result object
     * @param int $requestedPage after checking the questions of currentPage redirect to this page
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @ignorevalidaton $newResult
     */
    public function newAction(Result $newResult = null, $requestedPage = 0)
    {
        if ($newResult === null) { // workaround for fluid bug ##5636
            /** @var Result $newResult */
            $newResult = $this->objectManager->get(Result::class);
        }
        if ($this->user) {
            $newResult->setFeUser($this->user);
        }
        //check for the Access-Type
        switch ($this->settings['accessType']) {
            case 'feUser':
                $this->checkFeUser();
                break;
            case 'authCode':
                $this->checkAuthCode();
                $newResult->setAuthCode($this->authCode);
                break;
        }
        //check questionnaire-dependancy
        $this->checkDependancy();
        //check for restart
        $newResult = $this->checkRestart($newResult);
        //check if the max participations are reached
        $this->checkMaxParticipations();

        //get the correct requested start-page
        if ($requestedPage === 0 && !$this->settings['description']) {
            $requestedPage = 1;
        }

        //set the requested page
        $this->questionnaire->setPage($requestedPage);
        //get the questions and add them to the questionnaire
        $questions = $this->questionRepository->findAllForPid($GLOBALS['TSFE']->id);
        $this->questionnaire->setQuestions($questions);

        //SignalSlot for newAction
        $this->signalResult = $newResult;
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'newAction', [$this]);
        $newResult = $this->signalResult;

        if ($this->signalResult->getCrdate() === 0) {
            $this->signalResult->setCrdate(time());
        }

        if ($this->questionnaire->settings['startTime'] === 0) {
            $this->questionnaire->settings['startTime'] = time();
        }
        $this->settings['startTime2'] = time();
        if ($this->settings['randomQuestionsMax'] > 0) {
            $this->shuffleQuestions();
        }


        $this->view->assign('questions', $this->questionnaire->getQuestionsForPage($requestedPage));
        $this->view->assign('questionnaire', $this->questionnaire);
        $this->view->assign('newResult', $newResult);
    }


    /**
     * set StoragePid
     *
     * @param $storagePid
     * @return void
     */
    public function setStoragePid($storagePid)
    {
        $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $configuration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $currentPid['persistence']['storagePid'] = $storagePid;
        $configurationManager->setConfiguration(array_merge($configuration, $currentPid));
    }


    /**
     * initializes the createAction
     */
    public function initializeCreateAction()
    {
        //to get correct updates it is needed that a clone of the actual result is created
        //the temp_result stores the current newResult-data
        $this->temp_result = $this->request->getArgument('newResult');
        //SignalSlot for this action
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'initializeCreateAction', [$this, $this->arguments]);
        //check for autoSave
        //Premium function needs to be checked here anyway. The autosave Action is part of the premium
        if ((int)$this->settings['ajaxAutoSave'] === 1 && $GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
            if ($this->temp_result['__identity'] > 0) {
                $result = $this->resultRepository->findByUid($this->temp_result['__identity']);
                $this->request->setArgument('newResult', $result);
            }
        }
        //if the result is not new create the clone of the stored before it is updated
        //if the old-result is not stored, given answers of other pages will be deleted
        if ($this->temp_result['__identity'] > 0) {
            $result = $this->resultRepository->findByUid($this->temp_result['__identity']);
            if ($result) {
                $this->oldResult = clone $result;
            }
        }
    }

    /**
     * Creates a new questionnaire
     *
     * @param Result $newResult A fresh Questionnaire object
     * @param integer $currentPage check, validate and save the results of this page
     * @param integer $requestedPage after checking the questions of currentPage redirect to this page
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @ignorevalidation $newResult
     */
    public function createAction(
        Result $newResult,
        $currentPage,
        $requestedPage
    ) {
        //requestedPage => next Page to be shown
        $this->questionnaire->setRequestedPage($requestedPage);
        //currentPage => current Page, just send to this action
        $this->questionnaire->setPage($currentPage);
        //get all questions for this questionnaire
        $this->questionnaire->setQuestions($this->questionRepository->findAll());
        if ($this->user) {
            $newResult->setFeUser($this->user);
        }
        //check for the Access-Type
        switch ($this->settings['accessType']) {
            case 'feUser':
                $this->checkFeUser();
                break;
            case 'authCode':
                $this->checkAuthCode();
                $newResult->setAuthCode($this->authCode);
                break;
        }
        //validate the result
        $this->validateResult($newResult, $requestedPage);
        //rework the result so all given answers to all questions (not only current page) are stored
        $result = $this->getSavedAndMergedResult($newResult);
        //calculate the points of the questions and the result
        $result->calculatePoints();
        $this->resultRepository->update($result);

        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();

        $this->resultRepository->clearRATable();

        // check for last page
        if ($currentPage == $requestedPage) {
            //if there is a redirect page, redirect
            //else forward to endAction
            if ($this->settings['redirectFinished']) {
                $this->uriBuilder->setTargetPageUid($this->settings['redirectFinished']);
                $link = $this->uriBuilder->build();
                $this->redirectToUri($link);
            } else {
                /* Problems with forward and RealUrl
                 $this->forward('end', NULL, NULL, array(
                    'result' => $newResult
                ));*/

                // JVE - Jörg velletti Nov 2016 Changed hardCoded Template
                $TemplateRootPaths = $this->view->getTemplateRootPaths();
                foreach ($TemplateRootPaths as $templatePath) {
                    $tempTemplatePathAndFilename = $templatePath . '/Result/End.html';
                    if (is_file($tempTemplatePathAndFilename)) {
                        $templatePathAndFilename = $tempTemplatePathAndFilename;
                    }
                }

                $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                // JVE - Jörg velletti Nov 2016 Changed hardCoded Template

                $this->view->assign('result', $newResult);
                $this->view->assign('questionnaire', $this->questionnaire);
                $temp = false;
                $this->signalSlotDispatcher->dispatch(__CLASS__, 'endAction', [$newResult, $this, &$temp]);
                if ($temp) {
                    $this->redirectToUri($temp);
                }
            }
            //if not last page, set all stuff for questionnaire-page
        } else {
            //set the next page
            $this->questionnaire->setPage($requestedPage);
            //get questions
            $questions = $this->questionRepository->findAll();
            $this->questionnaire->setQuestions($questions);

            if (is_object($this->signalResult)) {
                if ($this->signalResult->getCrdate() === 0) {
                    $this->signalResult->setCrdate(time());
                }
            }

            if ((int)$this->questionnaire->settings['startTime'] === 0) {
                $this->questionnaire->settings['startTime'] = time();
            }
            if ($this->settings['randomQuestionsMax'] > 0) {
                $this->shuffleQuestions();
            }

            //signalSlot for this action

            $this->signalSlotDispatcher->dispatch(__CLASS__, 'createAction', [$this]);

            $this->view->assign('questions', $this->questionnaire->getQuestionsForPage($requestedPage));
            $this->view->assign('questionnaire', $this->questionnaire);
            $this->view->assign('newResult', $newResult);
        }

    }

    /**
     * Shows an chart => needs to be checked if really needed
     *
     * @param Result $result
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function showAction(Result $result = null)
    {
        if (!$result) {
            $this->flashMessageContainer->add(LocalizationUtility::translate('feView.noResultError',
                $this->extensionName),
                LocalizationUtility::translate('feView.noResultErrorTitle',
                    $this->extensionName), FlashMessage::WARNING);
        } else {
            $questionnaire = $this->questionnaireRepository->findByStoragePid($result->getPid());
            $this->view->assign('questionnaire', $questionnaire[0]);
            $this->view->assign('result', $result);
        }
    }

    /**
     * validate the result object
     * check for mandatory and correct answers
     *
     * @param Result $result
     * @param integer $requestedPage after checking the questions redirect to this page
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function validateResult(Result $result, $requestedPage = 1)
    {
        /* @var $resultQuestion ResultQuestion */
        //check for every question in result
        foreach ($result->getQuestions() as $resultQuestion) {
            if ($resultQuestion->getQuestion()) {
                // check if the question has to be answered correctly
                if ($resultQuestion->getQuestion()->getMustBeCorrect()) {
                    if (!$resultQuestion->isAnsweredCorrectly()) {
                        $this->moveToAction('new', $result, $requestedPage, 'mustBeCorrect');
                    }
                }

                // check if question is mandatory
                if ($resultQuestion->getQuestion()->getIsMandatory() && !$resultQuestion->getQuestion()->IsDependant()) {
                    if (!$resultQuestion->isAnswered()) {
                        $this->moveToAction('new', $result, $requestedPage, 'mandatory');
                    }
                }
            }
        }
        $result->setFeCruserId($GLOBALS['TSFE']->fe_user->user['uid']);
        if ($this->user) {
            $result->setFeUser($this->user);
        }
    }

    /**
     * move to given action
     *
     * @param string $action Action to call
     * @param Result $result A fresh Questionnaire object
     * @param integer $page needed for page navigation
     * @param string $flashMessage Key to show a flashMessage if needed
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function moveToAction(
        $action = 'new',
        Result $result,
        $page = 1,
        $flashMessage = ''
    ) {
        if (!empty($flashMessage)) {
            $this->addNewFlashMessage($flashMessage);
        }
        $this->forward($action, null, null, [
            'newResult' => $result,
            'requestedPage' => $page
        ]);
    }

    /**
     * get the created or merged result object
     * we have to merge them because $newResult contains the answered questions of the last page only.
     * All other answered questions come from DB
     *
     * @param Result $newResult
     * @return Result The modified result object
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function getSavedAndMergedResult(Result $newResult)
    {
        $uid = $newResult->getUid();
        if ($uid === null) {
            $result = $this->addResult($newResult);
        } else {
            $result = $this->updateResult($newResult);
        }
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'getSavedAndMergedResult', [$result, $this]);
        return $result;
    }

    /**
     * add the result to the DB
     *
     * @param Result $formResult This is the result from the form. NOT DB!
     * @return Result The added result object
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function addResult(Result $formResult)
    {
        $formResult = $this->modifyResultBeforeSave($formResult);
        $this->resultRepository->add($formResult);

        foreach ($formResult->getQuestions() as $rquestion) {
            $formResult->checkMatrixType($rquestion);
        }

        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();

        return $formResult;
    }

    /**
     * if uid is set, we have to merge the given $newResult object with the existing record in DB
     *
     * @param Result $formResult This is the result from the form. NOT DB!
     * @return Result The updated result object
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function updateResult(Result $formResult)
    {
        //merge the old and the new result-data
        $dbResult = $this->oldResult;
        if ($dbResult) {
            $updatedResult = $this->addQuestionToDbResult($formResult, $dbResult);
        } else {
            $updatedResult = $formResult;
        }
        $updatedResult->setPoints($updatedResult->getPoints() + $formResult->getPoints());
        $updatedResult->setMaxPoints($updatedResult->getMaxPoints() + $formResult->getMaxPoints());
        //check the result
        $result = $this->modifyResultBeforeSave($updatedResult);
        $this->resultRepository->update($result);

        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();

        return $result;
    }

    /**
     * here you/we make some little modifications to the result object before saving
     *
     * @param Result $result
     * @return Result
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function modifyResultBeforeSave(Result $result)
    {
        // set timestamp for finished if last page was reached
        if ($this->questionnaire && $this->questionnaire->getIsFinished()) {
            $result->setFinished(time());
        }
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'modifyResultBeforeSave', [$result, $this]);

        return $result;
    }

    /**
     * add the questions of the form result to the db result object
     *
     * @param Result $formResult The result object which comes from the form
     * @param Result $dbResult The result object which comes from DB
     * @return Result The updated db result
     */
    public function addQuestionToDbResult(
        Result $formResult,
        Result $dbResult
    ) {
        $formQuestions = $formResult->getQuestions();

        /** @var ResultQuestion $fQuestion */
        foreach ($formQuestions as $fQuestion) {
            if ($fQuestion->getQuestion() && $fQuestion->getQuestion()->getType() === 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question') {
                $dbResult->addOrUpdateQuestion($fQuestion);
            }
        }
        $formResult->setQuestions($dbResult->getQuestions());
        return $formResult;
    }

    /**
     * checks the logged in user
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function checkFeUser()
    {
        if (!$this->user) {
            $this->forward('feUserAccess');
        }
    }

    /**
     * Action to show the FeUser-Access Error
     *
     * @return void
     */
    public function feUserAccessAction()
    {

    }

    /**
     * checkes the dependancy of the Questionnaire
     */
    public function checkDependancy()
    {
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'checkDependancy', [$this]);
    }

    /**
     * Action to show the FeUser-Access Error
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire
     * @return void
     */
    public function dependancyAccessAction(\Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire)
    {
        $this->view->assign('questionnaire', $questionnaire);
    }

    /**
     * checks the logged in autchode
     */
    public function checkAuthCode()
    {
        //direct call with &authCode= in URI
        if ($_REQUEST['authCode']) {
            $this->request->setArgument('code', $_REQUEST['authCode']);
        }
        if ($this->request->hasArgument('authCode')) {
            $code = $this->authCodeRepository->findByUid($this->request->getArgument('authCode'));
            if ($code) {
                $this->authCode = $code;
                if (!$this->authCode->getFirstactive()) {
                    $this->authCode->setFirstactive(time());
                    $this->authCodeRepository->update($this->authCode);

                    $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                    $persistenceManager->persistAll();
                }
                return true;
            }
        } elseif ($this->request->hasArgument('code')) {
            $codes = $this->authCodeRepository->findByAuthCode($this->request->getArgument('code'));
            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($codes[0], 'code');	exit;
            if ($codes[0]) {
                $this->authCode = $codes[0];
                if (!$this->authCode->getFirstactive()) {
                    $this->authCode->setFirstactive(time());
                    $this->authCodeRepository->update($this->authCode);

                    $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                    $persistenceManager->persistAll();
                }
                return true;
            }
        }
        $this->forward('authCodeAccess');
    }

    /**
     * Action to show the AuthCode-Access Error
     *
     * @return void
     */
    public function authCodeAccessAction()
    {

    }

    /**
     * checks the max participations allowed
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function checkMaxParticipations()
    {
        if ($this->settings['participations']['max'] > 0) {
            if ($this->settings['accessType'] === 'free') {
                $counted = $this->resultRepository->findAll()->count();
            } elseif ($this->settings['accessType'] === 'feUser') {
                $counted = $this->resultRepository->findByFeUser($this->user)->count();
            } elseif ($this->settings['accessType'] === 'authCode') {
                $counted = $this->resultRepository->findByAuthCode($this->authCode->getUid())->count();
            }
            if ($counted >= $this->settings['participations']['max']) {
                $this->forward('maxParticipations');
            }
        }
    }

    /**
     * Action to show the maxParticipations Error
     *
     * @return void
     */
    public function maxParticipationsAction()
    {

    }

    /**
     * Check if the user can restart a started participation
     *
     * @param Result $result
     * @return Result
     */
    private function checkRestart(Result $result)
    {
        if ($this->settings['accessType'] !== 'free' && $this->settings['restart']) {
            //fetch the last participation of the user
            if ($result->getFeUser()) {
                $parts = $this->resultRepository->findByFeUser($result->getFeUser())->toArray();
                if (count($parts) > 0) {
                    $last = $parts[count($parts) - 1];
                    if (!$last->getFinished()) {
                        $result = $last;
                    }
                }
                //or the authCode
            } elseif ($result->getAuthCode()) {
                $parts = $this->resultRepository->findByAuthCode($result->getAuthCode())->toArray();
                if (count($parts) > 0) {
                    $last = $parts[count($parts) - 1];
                    if (!$last->getFinished()) {
                        $result = $last;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Action to show the End Page of the questionnaire
     *
     * @param Result $result
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @dontvalidate $result
     */
    public function endAction(Result $result = null)
    {
        if (!$result) {
            $result = $this->resultRepository->findByUid($this->request->getArgument('result'));
        }
        $questionnaire = $this->questionnaireRepository->findByStoragePid($result->getPid());

        $this->view->assign('result', $result);
        $this->view->assign('questionnaire', $questionnaire);
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'endAction', [$result, $this]);
    }


    /**
     * @author joergVelletti <jvelletti@allplan.com>
     * @param \Kennziffer\KeQuestionnaire\Controller\ResultController
     */
    public function shuffleQuestions()
    {
        $questions = $this->questionnaire->getQuestions();
        if ($questions->count()) {
            $page = 1;
            $pages = [];
            // seperate all questions for each page
            foreach ($questions as $question) {
                if ($question instanceof \Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\PageBreak) {
                    $page++;
                    continue;
                }
                $pages[$page][] = $question;
            }
            $randomQuestionsMax = $this->settings['randomQuestionsMax'];
            foreach ($pages as $page => $questions) {

                $pageStorage = GeneralUtility::makeInstance(ObjectStorage::class);
                shuffle($questions);

                $i = 0;

                foreach ($questions as $question) {
                    if ($i < $randomQuestionsMax) {
                        $pageStorage->attach($question);
                    } else {
                        break;
                    }
                    $i++;
                }

                // $this->questionnaire->questionsByPage[$page] = $pageStorage;
                $this->questionnaire->setShuffledQuestionsByPage($pageStorage, $page);
            }


        }

    }
}
