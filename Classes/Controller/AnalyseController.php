<?php

namespace Kennziffer\KeQuestionnaire\Controller;

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
 * Analyse Controller
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AnalyseController extends BackendController
{

    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\Analysis
     */
    protected $analysis;

    /**
     * inject analysis
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\Analysis $analysis
     */
    public function injectAnalysis(\Kennziffer\KeQuestionnaire\Utility\Analysis $analysis)
    {
        $this->analysis = $analysis;
    }

    /**
     * initialize Action
     *
     * @return void
     */
    public function initializeAction()
    {
        parent::initializeAction();
        $this->analysis->setSettings($this->settings['analysis']);
    }

    /**
     * action index
     */
    public function indexAction()
    {
        $this->view->assign('questionnaires', $this->questionnaireRepository->findAll());
    }

    /**
     * action analyse questions
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @ignorevalidaton $plugin
     */
    public function questionsAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }

        $questionnaire = $this->questionnaireRepository->findByUid($this->plugin['uid']);
        $questions = $this->questionRepository->findAllForPid($questionnaire->getStoragePid());
        // if a question is selected, create the analysis for this question
        // else select the first keq-element of type question for analysis
        if ($this->request->hasArgument('question')) {
            $q_id = $this->request->getArgument('question');
            $question = $this->questionRepository->findByUidFree($q_id);
        } else {
            foreach ($questions as $q) {
                if ($question == null) {
                    if ($q->getShortType() === 'Question') {
                        $question = $q;
                    }
                }
            }
        }
        //fill the questions in the questionnaire
        $questionnaire->setQuestions($questions);
        //get the results for this questionnaire
        $results = $this->resultRepository->findAllForPid($questionnaire->getStoragePid());
        //if there is a question create a cart
        if ($question) {
            $this->view->assign('chart', $this->analysis->createQuestionAnalysis($question, $results));
        }
        $this->view->assign('question', $question);
        $this->view->assign('plugin', $questionnaire);
        $this->view->assign('counter', $this->countParticipations());
    }

    /**
     * Shows the general anlysis: participation amount and date linechart
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @ignorevalidaton $plugin
     */
    public function generalAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }
        //get the questionnaire//tt_content element with the given uid
        $questionnaire = $this->questionnaireRepository->findByUid($this->plugin['uid']);
        //get the results for this questionnaire
        $results = $this->resultRepository->findAllForPidRaw($questionnaire->getStoragePid());
        //create the general chart
        $this->view->assign('chart', $this->analysis->createParticipationAnalysis($results, $questionnaire));
        $this->view->assign('plugin', $questionnaire);
        $this->view->assign('counter', $this->countParticipations());
    }
}
