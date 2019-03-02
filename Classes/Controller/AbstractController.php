<?php

namespace Kennziffer\KeQuestionnaire\Controller;


use Kennziffer\KeQuestionnaire\Domain\Model\Step;
use Kennziffer\KeQuestionnaire\Domain\Repository\QuestionnaireRepository;
use Kennziffer\KeQuestionnaire\Object\DataMapper;
use Kennziffer\KeQuestionnaire\View\TemplateView;

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
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * resultRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\ResultRepository
     */
    protected $resultRepository;

    /**
     * questionRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository
     */
    protected $questionRepository;

    /**
     * questionnaireRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionnaireRepository
     */
    protected $questionnaireRepository;

    /**
     * authCodeRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\AuthCodeRepository
     */
    var $authCodeRepository;

    /**
     * questionnaire
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire
     */
    protected $questionnaire;

    /**
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\ExtConf
     */
    protected $extConf;

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\Localization
     */
    protected $localization;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected $steps;


    /**
     * injectResultRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\ResultRepository $resultRepository
     * @return void
     */
    public function injectResultRepository(
        \Kennziffer\KeQuestionnaire\Domain\Repository\ResultRepository $resultRepository
    ) {
        $this->resultRepository = $resultRepository;
    }

    /**
     * injectQuestionRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository $questionRepository
     * @return void
     */
    public function injectQuestionRepository(
        \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository $questionRepository
    ) {
        $this->questionRepository = $questionRepository;
    }

    /**
     * injectAuthCodeRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\AuthCodeRepository $authCodeRepository
     * @return void
     */
    public function injectAuthCodeRepository(
        \Kennziffer\KeQuestionnaire\Domain\Repository\AuthCodeRepository $authCodeRepository
    ) {
        $this->authCodeRepository = $authCodeRepository;
    }

    /**
     * injectQuestionnaire
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire
     * @return void
     */
    public function injectQuestionnaire(\Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

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
     * inject extConf
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ExtConf $extConf
     * @return void
     */
    public function injectExtConf(\Kennziffer\KeQuestionnaire\Domain\Model\ExtConf $extConf)
    {
        $this->extConf = $extConf;
    }

    /**
     * inject signal slots
     *
     * @param \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
     * @return void
     */
    public function injectSignalSlotDispatcher(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }

    /**
     * inject localization
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\Localization $localization
     */
    public function injectLocalization(\Kennziffer\KeQuestionnaire\Utility\Localization $localization)
    {
        $this->localization = $localization;
    }

    /**
     * inject steps
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $steps
     * @return void
     */
    public function injectSteps(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $steps)
    {
        $this->steps = $steps;
    }


    /**
     * @var string defaultViewObjectName use custom extended \TYPO3\CMS\Fluid\View\TemplateView
     */
    protected $defaultViewObjectName = TemplateView::class;

    /**
     * set the BasePartialRootPath for all Controllers extending this one
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @return void
     */
    protected function setViewConfiguration(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        parent::setViewConfiguration($view);
        // Template Path Override
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        //check if there is a different Path in the base configuration
        if (isset($extbaseFrameworkConfiguration['view']['basePartialRootPath'])
            && $extbaseFrameworkConfiguration['view']['basePartialRootPath'] !== ''
            && method_exists($view, 'setBasePartialRootPath')) {
            $view->setBasePartialRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['basePartialRootPath']));
        }
    }


    /**
     * initializes the actions
     */
    public function initializeAction()
    {
        parent::initializeAction();
        if (!is_object($this->questionnaireRepository)) {
            $this->questionnaireRepository = $this->objectManager->get(QuestionnaireRepository::class);
        }

        // initialize steps
        if ($this->steps && $this->steps->count() === 0) {
            if (is_array($this->settings['steps']) && count($this->settings['steps'])) {
                /* @var $dataMapper \Kennziffer\KeQuestionnaire\Object\DataMapper */
                $dataMapper = $this->objectManager->get(DataMapper::class);
                $steps = $dataMapper->map(Step::class, $this->settings['steps']);
                foreach ($steps as $step) {
                    $this->steps->attach($step);
                }
            }
        }
    }

    /**
     * initializes the view with additional placeholders/markers
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     * @return void
     */
    public function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        if (is_array($GLOBALS['TSFE']->fe_user->user) && $this->extConf->getEnableFeUserMarker()) {
            $view->assign('feUser', $GLOBALS['TSFE']->fe_user->user);
        }
    }

    /**
     * Override getErrorFlashMessage to present
     * nice flash error messages.
     *
     * @return string
     */
    protected function getErrorFlashMessage() : string
    {
        $defaultFlashMessage = parent::getErrorFlashMessage();
        $locallangKey = sprintf('error.%s.%s', $this->request->getControllerName(), $this->actionMethodName);

        return $this->translate($locallangKey, $defaultFlashMessage);
    }

    /**
     * helper function to render localized flashmessages
     *
     * @param string $action
     * @param integer $severity optional severity code. One of the \TYPO3\CMS\Core\Messaging\FlashMessage constants
     * @return void
     */
    public function addNewFlashMessage($action, $severity = \TYPO3\CMS\Core\Messaging\FlashMessage::OK)
    {
        $messageLocallangKey = sprintf('flashmessage.%s.%s', $this->request->getControllerName(), $action);
        $localizedMessage = $this->translate($messageLocallangKey, '[' . $messageLocallangKey . ']');
        $titleLocallangKey = sprintf('%s.title', $messageLocallangKey);
        $localizedTitle = $this->translate($titleLocallangKey, '[' . $titleLocallangKey . ']');
        $this->flashMessageContainer->add($localizedMessage, $localizedTitle, $severity);
    }

    /**
     * helper function to use localized strings in BlogExample controllers
     *
     * @param string $key locallang key
     * @param string $defaultMessage
     * @return string
     */
    protected function translate($key, $defaultMessage = '')
    {
        $message = $this->localization->translate($key);
        if ($message === null) {
            $message = $defaultMessage;
        }
        return $message;
    }

    /**
     * calls the next step as defined in TS (plugin.kequestionnaire.steps)
     * Sample:
     * - open questionnaire
     * - logging
     * - mailing
     * - Evaluation
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result
     */
    protected function nextStep(\Kennziffer\KeQuestionnaire\Domain\Model\Result $result)
    {
        // get current environment vars
        $action = $this->request->getControllerActionName();
        $controller = $this->request->getControllerName();
        $extension = $this->request->getControllerExtensionName();

        // search for current step in $this->steps
        /* @var $step \Kennziffer\KeQuestionnaire\Domain\Model\Step */
        foreach ($this->steps as $key => $step) {
            if ($step->getAction() === $action && $step->getController() === $controller && $step->getExtension() === $extension) {
                $this->steps->next();
                $nextStep = $this->steps->current();
                break;
            }
        }

        $method = $nextStep->getType();
        $this->$method($nextStep->getAction(), $nextStep->getController(), $nextStep->getExtension(),
            ['result' => $result]);
    }

    /**
     * Create getSettings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }
}

