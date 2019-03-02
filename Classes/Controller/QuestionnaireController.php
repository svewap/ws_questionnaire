<?php

namespace WapplerSystems\WsQuestionnaire\Controller;

use WapplerSystems\WsQuestionnaire\Validation\Email;

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
 * @package ws_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class QuestionnaireController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * questionnaireRepository
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Repository\QuestionnaireRepository
     */
    protected $questionnaireRepository;

    /**
     * authCodeRepository
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Repository\AuthCodeRepository
     */
    protected $authCodeRepository;

    /**
     * resultRepository
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Repository\ResultRepository
     */
    protected $resultRepository;

    /**
     * @var \WapplerSystems\WsQuestionnaire\Utility\Mail
     */
    protected $mailSender;

    /**
     * injectQuestionnaireRepository
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Repository\QuestionnaireRepository $questionnaireRepository
     * @return void
     */
    public function injectQuestionnaireRepository(
        \WapplerSystems\WsQuestionnaire\Domain\Repository\QuestionnaireRepository $questionnaireRepository
    ) {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    /**
     * injectAuthCodeRepository
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Repository\AuthCodeRepository $authCodeRepository
     * @return void
     */
    public function injectAuthCodeRepository(
        \WapplerSystems\WsQuestionnaire\Domain\Repository\AuthCodeRepository $authCodeRepository
    ) {
        $this->authCodeRepository = $authCodeRepository;
    }

    /**
     * injectResultRepository
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Repository\ResultRepository $resultRepository
     * @return void
     */
    public function injectResultRepository(
        \WapplerSystems\WsQuestionnaire\Domain\Repository\ResultRepository $resultRepository
    ) {
        $this->resultRepository = $resultRepository;
    }

    /**
     * inject mailSender
     *
     * @param \WapplerSystems\WsQuestionnaire\Utility\Mail $mail
     */
    public function injectMail(\WapplerSystems\WsQuestionnaire\Utility\Mail $mail)
    {
        $this->mailSender = $mail;
    }

    /**
     * action list
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function listAction()
    {
        $this->view->assign('questionnaires', $this->getQuestionnaires());
        //SignalSlot for listAction
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'listAction', [$this]);
    }

    /**
     * action reclaimAuthcode
     *
     * @return void
     */
    public function reclaimAuthCodeAction()
    {

    }

    /**
     * Checks if the value is valid email
     *
     * @param string $value value
     * @return boolean
     */
    public function isValidEmail($value)
    {
        $class = Email::class;
        if (class_exists($class)) {
            $objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager;
            $validator = $objectManager->get($class);
            if ($validator instanceof \WapplerSystems\WsQuestionnaire\ValidationAbstractValidation) {
                /* @var $validator \WapplerSystems\WsQuestionnaire\ValidationAbstractValidation */
                return $validator->isValid($value, $this);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * get the selected Questionnaires
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function getQuestionnaires()
    {
        if ($this->settings['questionnaires']) {
            $questionnaires = $this->questionnaireRepository->findForUids($this->settings['questionnaires']);
        } else {
            $questionnaires = $this->questionnaireRepository->findAll();
        }

        $list = [];
        $userId = null;
        if ($GLOBALS['TSFE']->fe_user) {
            $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        }
        switch ($this->settings['listType']) {
            case 'all':
                $list = $questionnaires;
                break;
            case 'used':
                if ($userId) {
                    foreach ($questionnaires as $questionnaire) {
                        if (count($questionnaire->getUserResults($userId)) > 0) {
                            $list[] = $questionnaire;
                        }
                    }
                }
                break;
            case 'unused':
                if ($userId) {
                    foreach ($questionnaires as $questionnaire) {
                        if (count($questionnaire->getUserResults($userId)) === 0) {
                            $list[] = $questionnaire;
                        }
                    }
                }
                break;
        }

        return $list;
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
