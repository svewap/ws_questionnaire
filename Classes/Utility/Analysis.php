<?php

namespace Kennziffer\KeQuestionnaire\Utility;

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

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;
use Kennziffer\KeQuestionnaire\Domain\Model\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultAnswerRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultQuestionRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 *
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Analysis
{
    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\jqPlot
     */
    protected $jqPlot;

    /**
     * lokalization
     *
     * @var \Kennziffer\KeQuestionnaire\Utility\Localization
     */
    protected $localization;

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * @var array
     */
    protected $settings;

    /**
     * get ExtConf Settings for Analysis
     *
     * @param array $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * inject jqPlot
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\JqPlot $jqPlot
     */
    public function injectJqPlot(\Kennziffer\KeQuestionnaire\Utility\JqPlot $jqPlot)
    {
        $this->jqPlot = $jqPlot;
    }

    /**
     * inject Localization
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\Localization $localization
     * @return void
     */
    public function injectLocalization(\Kennziffer\KeQuestionnaire\Utility\Localization $localization)
    {
        $this->localization = $localization;
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
     * create Participation Analysis
     *
     * @param array $results
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire
     * @return string
     */
    public function createParticipationAnalysis(
        $results,
        \Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire
    ): string {
        $data = $this->createParticipationData($results);
        return $this->jqPlot->createLineChart('participation_chart_' . $questionnaire->getUid(), $data);
    }

    /**
     * create Question Analysis
     *
     * @param Question $question
     * @param array $results
     * @return array
     * @return array
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function createQuestionAnalysis(Question $question, $results)
    {
        $charts = [];
        //create Data and Chart for all participations
        $adata = $this->createQuestionDataArray('all', $question, $results);
        $charts['all'] = $this->createChartWithData('all', $adata, $question);
        //create Data and Chart for finished participations
        $fdata = $this->createQuestionDataArray('finished', $question, $results);
        $charts['finished'] = $this->createChartWithData('finished', $fdata, $question);
        return $charts;
    }

    /**
     * Create the Charts for the Data
     *
     * @param string $type
     * @param array $data
     * @param Question $question
     * @return array
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    private function createChartWithData($type, $data, Question $question)
    {
        $charts = '';
        $divs = '';
        // the created data is the basis for the type of chart created
        foreach ($data as $atype => $values) {
            $chartType = 'default';
            if ($this->settings['chartTypes'][$atype]) {
                $chartType = $this->settings['chartTypes'][$atype];
            }

            switch ($atype) {
                case 'Radiobutton':
                case 'Checkbox':
                case 'DataPrivacy':
                    $divs .= '<div id="chart_' . $type . '_' . $atype . '_' . $question->getUid() . '" style="height:300px; width:500px;"></div>' . "\n";
                    $charts .= $this->jqPlot->getChart($chartType, $type . '_' . $atype, $values, $question) . "\n";
                    $divs .= $this->createLineOutput($values, true);
                    break;
                case 'MatrixHeader':
                    foreach ($values as $header) {
                        foreach ($header['rows'] as $nr => $row) {
                            $divs .= '<h5>' . $row['answer']->getTitle() . '</h5>';
                            if (!$row['answer']->isTitleLine()) {
                                foreach ($row as $rtype => $rvalues) {
                                    switch ($rtype) {
                                        case 'Radiobutton':
                                        case 'Checkbox':
                                            $divs .= '<div id="chart_' . $type . '_' . $atype . '_' . $rtype . '_' . $nr . '_' . $question->getUid() . '" style="height:300px; width:500px;"></div>' . "\n";
                                            $charts .= $this->jqPlot->getChart($chartType,
                                                    $type . '_' . $atype . '_' . $rtype . '_' . $nr, $rvalues,
                                                    $question) . "\n";
                                            break;
                                        case 'SingleInput':
                                        case 'SingleSelect':
                                            $divs .= $this->createLineOutput($rvalues);
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'SemanticDifferential':
                case 'Slider':
                case 'SingleSelect':
                    foreach ($values as $nr => $data) {
                        $plotValues = $data['values'];
                        if ($data['answer']) {
                            $divs .= '<h5>' . $data['answer']->getTitle() . '</h5>';
                        } else {
                            $divs .= '<h5>...</h5>';
                        }
                        $divs .= '<div id="chart_' . $type . '_' . $atype . '_' . $nr . '_' . $question->getUid() . '" style="height:300px; width:500px;"></div>' . "\n";
                        $charts .= $this->jqPlot->getChart($chartType, $type . '_' . $atype . '_' . $nr, $plotValues,
                                $question, $data['labels']) . "\n";
                    }
                    break;
                case 'DDImage':
                    //rework the values so the basis of the chart is the Area not the image
                    $reworked = [];
                    foreach ($values as $nr => $data) {
                        foreach ($data['values'] as $area => $tvalues) {
                            $reworked[$area][$data['answer']->getTitle()]['value'] += $tvalues['value'];
                        }
                    }
                    ksort($reworked);
                    foreach ($reworked as $area => $data) {
                        $plotValues = $data;
                        $divs .= '<h5> Area ' . $area . '</h5>';
                        $divs .= '<div id="chart_' . $type . '_' . $atype . '_' . $area . '_' . $question->getUid() . '" style="height:300px; width:500px;"></div>' . "\n";
                        $charts .= $this->jqPlot->getChart($chartType, $type . '_' . $atype . '_' . $area, $plotValues,
                                $question, []) . "\n";
                    }
                    break;
                case 'DDAreaImage':
                case 'DDAreaSequence':
                case 'DDAreaSimpleScale':
                    foreach ($values as $data) {
                        $divs .= '<h4>' . $data['answer']->getTitle() . '</h4>';
                    }
                    break;
                case 'RankingSelect':
                case 'RankingOrder':
                case 'RankingInput':
                case 'SingleInput':
                case 'MultiInput':
                case 'ClozeText':
                case 'ClozeTextDD':
                    $divs .= $this->createLineOutput($values);
                    break;
                case 'MatrixRow':
                case 'ClozeTerm':
                case 'RankingTerm':
                    //Nothing, Output generated in main-element
                    // MatrixHeader => Matrix
                    // ClozeTerm => ClozeTextDD, ClozeText
                    // RankingTerm => RankingSelect, RankingOrder, RankingInput
                    break;
                default:
                    $this->signalData = false;
                    $this->signalSlotDispatcher->dispatch(__CLASS__, 'createChartWithData',
                        [$type, $data, $question, $this]);
                    if ($this->signalData) {
                        $divs .= $this->signalData['div'];
                        $charts .= $this->signalData['chart'];
                    } else {
                        $charts = "$(document).ready(function(){
									alert('no " . $type . '_' . $atype . " chart found');
								  });";
                    }
                    break;
            }
        }

        $returner = [
            'chart' => $charts,
            'div' => $divs
        ];
        return $returner;
    }

    /**
     * create String lines output
     *
     * @param array $values
     * @param boolean $useAdditionalValues
     * @return string lines
     */
    public function createLineOutput($values, $useAdditionalValues = false): string
    {
        $lines = '';
        foreach ($values as $data) {
            if ($useAdditionalValues) {
                $lineValues = $data['additionalValues'];
            } else {
                $lineValues = $data['value'];
            }

            if (is_array($lineValues)) {
                $lines .= '<h5>' . $data['answer']->getTitle() . '</h5>';
                $lines .= '<ul class="keqLineAnalysis">';
                foreach ($lineValues as $val) {
                    $lines .= '<li>' . $val . '</li>';
                }
                $lines .= '</ul><br />';
            }
        }
        return $lines;
    }

    /**
     * create image outout
     *
     * @param array $values
     * @param string $base
     * @return string lines
     */
    public function createImageOutput($values, $base): string
    {
        $lines = '';

        foreach ($values as $data) {
            if (is_array($data['value'])) {
                $lines .= '<h5>' . $data['answer']->getTitle() . '</h5>';
                foreach ($data['value'] as $val) {
                    $lines .= '<div style="padding: 10px; 5px; display: block; width: auto; float: left;">';
                    $lines .= '<img src="' . $base . $val . '" alt="' . $base . $val . '" />';
                    $lines .= '</div>';
                }
            }
        }

        return $lines;
    }

    /**
     * create data array
     *
     * @param string $type
     * @param Question $question
     * @param array $results
     * @return array
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function createQuestionDataArray(
        $type,
        Question $question,
        $results
    ) {
        $answers = [];
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ResultQuestionRepository $resultQuestionRepository */
        $resultQuestionRepository = $objectManager->get(ResultQuestionRepository::class);
        /** @var ResultAnswerRepository $resultAnswerRepository */
        $resultAnswerRepository = $objectManager->get(ResultAnswerRepository::class);

        /** @var Answer $answer */
        foreach ($question->getAnswers() as $answer) {
            switch ($answer->getShortType()) {
                case 'Radiobutton':
                    if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                        $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                    }
                    //get the corresponding ranswers and count
                    $answers[$answer->getShortType()][$answer->getUid()]['value'] = $resultAnswerRepository->countResultAnswersForAnswer($answer);

                    //Get all additionalValue for answer
                    $rAnswers = $resultAnswerRepository->getResultAnswersForAnswer($answer);
                    /** @var ResultAnswer $rAnswer */
                    foreach ($rAnswers as $rAnswer) {
                        if ($rAnswer->getAdditionalValue()) {
                            $answers[$answer->getShortType()][$answer->getUid()]['additionalValues'][] = $rAnswer->getAdditionalValue();
                        }
                    }
                    if (is_array($answers[$answer->getShortType()][$answer->getUid()]['additionalValues'])) {
                        $answers[$answer->getShortType()][$answer->getUid()]['additionalValues'] = array_unique($answers[$answer->getShortType()][$answer->getUid()]['additionalValues']);
                    }

                    break;
                case 'DataPrivacy':
                    if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                        $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                    }
                    //get the corresponding ranswers and count
                    $answers[$answer->getShortType()][$answer->getUid()]['value'] = $resultAnswerRepository->countResultAnswersForAnswer($answer);
                    break;
                case 'Checkbox':
                    if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                        $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                    }
                    //get the corresponding ranswers and count
                    $answers[$answer->getShortType()][$answer->getUid()]['value'] = $resultAnswerRepository->countResultAnswersForAnswerAndValue($answer);

                    //Get all additionalValue for answer
                    $rAnswers = $resultAnswerRepository->getResultAnswersForAnswer($answer);
                    foreach ($rAnswers as $rAnswer) {
                        if ($rAnswer->getAdditionalValue()) {
                            $answers[$answer->getShortType()][$answer->getUid()]['additionalValues'][] = $rAnswer->getAdditionalValue();
                        }
                    }
                    if (is_array($answers[$answer->getShortType()][$answer->getUid()]['additionalValues'])) {
                        $answers[$answer->getShortType()][$answer->getUid()]['additionalValues'] = array_unique($answers[$answer->getShortType()][$answer->getUid()]['additionalValues']);
                    }

                    break;
                case 'SemanticDifferential':
                    $labels = $answer->getStepLabelsValuesArray();
                    if ($labels) {
                        $answers[$answer->getShortType()][$answer->getUid()]['labels'] = $labels;
                    }
                    break;
                case 'Slider':
                case 'SingleSelect':
                case 'DDImage':
                    //$singleVal basiert auf einer gegeben Antwort, daher müssen hier alle ResultAnswers geholt werden, die zu der Frage gehören
                    $ranswers = $resultAnswerRepository->findForAnswerRaw($answer);
                    foreach ($ranswers as $ranswer) {
                        $singleVal = $ranswer['value'];
                        if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                            $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                        }
                        if (!$answers[$answer->getShortType()][$answer->getUid()]['values'][$singleVal]['value']) {
                            $answers[$answer->getShortType()][$answer->getUid()]['values'][$singleVal]['value'] = 0;
                        }
                        $answers[$answer->getShortType()][$answer->getUid()]['values'][$singleVal]['value']++;
                    }
                    break;
                case 'MatrixHeader':
                    if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                        $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                    }
                    //for each row
                    foreach ($answer->getRows($question) as $row) {
                        if (!$answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()]['answer']) {
                            $answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()]['answer'] = $row;
                        }
                        foreach ($answer->getCols() as $column) {
                            if (!$answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()][$column->getShortType()][$column->getUid()]['answer']) {
                                $answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()][$column->getShortType()][$column->getUid()]['answer'] = $column;
                            }
                            if (!$row->isTitleLine()) {
                                switch ($column->getShortType()) {
                                    case 'Radiobutton':
                                        $answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()][$column->getShortType()][$column->getUid()]['value'] = $resultAnswerRepository->countResultAnswersForRowAndValue($row,
                                            $column->getUid());
                                        break;
                                    case 'Checkbox':
                                        $answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()][$column->getShortType()][$column->getUid()]['value'] = $resultAnswerRepository->countResultAnswersForRowAndCol($row,
                                            $column->getUid());
                                        break;
                                    case 'SingleInput':
                                    case 'SingleSelect':
                                        $rrows = $resultAnswerRepository->getResultAnswersForRowAndColRaw($row,
                                            $column->getUid());
                                        foreach ($rrows as $rrow) {
                                            $answers[$answer->getShortType()][$answer->getUid()]['rows'][$row->getUid()][$column->getShortType()][$column->getUid()]['value'][$rrow['uid']] = $rrow['value'];
                                        }
                                        break;
                                }
                            }
                        }
                    }
                    break;
                case 'ClozeText':
                case 'ClozeTextDD':
                    foreach ($results as $result) {
                        $resultQuestion = $resultQuestionRepository->findByQuestionAndResultRaw($question, $result);
                        $rAnswers = $resultAnswerRepository->findForResultQuestionRaw($resultQuestion[0]['uid']);
                        $line = $answer->getUserText($rAnswers, $question);
                        if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                            $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                        }
                        $answers[$answer->getShortType()][$answer->getUid()]['value'][] = $line;
                    }
                    break;
                case 'RankingSelect':
                case 'RankingOrder':
                case 'RankingInput':
                    foreach ($results as $result) {
                        $line = $answer->getRankingLine($result, $question);
                        if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                            $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                        }
                        $answers[$answer->getShortType()][$answer->getUid()]['value'][] = $line;
                    }
                    break;
                case 'SingleInput':
                case 'MultiInput':
                    if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                        $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                    }
                    foreach ($results as $result) {
                        $resultQuestion = $resultQuestionRepository->findByQuestionAndResultRaw($question, $result);
                        $rAnswers = $resultAnswerRepository->findForResultQuestionRaw($resultQuestion[0]['uid']);
                        foreach ($rAnswers as $ranswer) {
                            if ($answer->getUid() == $ranswer['answer']) {
                                $answers[$answer->getShortType()][$answer->getUid()]['value'][] = $ranswer['value'];
                            }
                        }
                    }
                    break;
                case 'DDAreaImage':
                case 'DDAreaSequence':
                case 'DDAreaSimpleScale':
                    if (!$answers[$answer->getShortType()][$answer->getUid()]['answer']) {
                        $answers[$answer->getShortType()][$answer->getUid()]['answer'] = $answer;
                    }
                    break;
                default:
                    $this->signalData = false;
                    $this->signalSlotDispatcher->dispatch(__CLASS__, 'createQuestionDataArray',
                        [$type, $question, $results, $this]);
                    if ($this->signalData) {
                        $answers = $this->signalData;
                    }
                    break;
            }
        }

        return $answers;
    }

    /**
     * create dataarray for participations
     * @param array $results
     * @return array
     */
    public function createParticipationData($results)
    {
        $data = [];
        $data['finished']['title'] = $this->localization->translate('participationChart.finished');
        $data['all']['title'] = $this->localization->translate('participationChart.all');

        foreach ($results as $result) {
            if (is_array($result)) {
                $date = date('Y-m-d', $result['crdate']);
                if (!$data['finished']['dates'][$date]) {
                    $data['finished']['dates'][$date] = 0;
                }
                if (!$data['all']['dates'][$date]) {
                    $data['all']['dates'][$date] = 0;
                }
                if ($result['finished'] > 0) {
                    $data['finished']['dates'][$date]++;
                }
                $data['all']['dates'][$date]++;
            } else {
                $date = date('Y-m-d', $result->getCrdate());
                if (!$data['finished']['dates'][$date]) {
                    $data['finished']['dates'][$date] = 0;
                }
                if (!$data['all']['dates'][$date]) {
                    $data['all']['dates'][$date] = 0;
                }
                if ($result->getFinished() > 0) {
                    $data['finished']['dates'][$date]++;
                }
                $data['all']['dates'][$date]++;
            }
        }
        return $data;
    }
}

