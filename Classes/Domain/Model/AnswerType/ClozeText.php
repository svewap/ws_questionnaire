<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\AnswerType;

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question;
use Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultQuestionRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
class ClozeText extends Answer
{

    /**
     * Terms
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer>
     * @lazy
     */
    protected $terms;

    /**
     * WordPositions
     *
     * @var array
     * @lazy
     */
    protected $wordPositions;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     *
     * @param Question $question
     * @param boolean $useRepository
     * @return ObjectStorage Array containing the word positions
     */
    public function getTerms(
        Question $question,
        $useRepository = false
    ) {
        $this->terms = GeneralUtility::makeInstance(ObjectStorage::class);
        if ($useRepository) {
            // Aus dem Repository holen, nicht aus der Frage, da sonst zuordnungen verschwinden
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            /** @var AnswerRepository $rep */
            $rep = $objectManager->get(AnswerRepository::class);
            /** @var Typo3QuerySettings $querySettings */
            $querySettings = $objectManager->get(Typo3QuerySettings::class);
            $querySettings->setRespectStoragePage(false);
            $querySettings->setRespectSysLanguage(false);
            $rep->setDefaultQuerySettings($querySettings);
            $answers = $rep->findByQuestion($question);
        } else {
            $answers = $question->getAnswers();
        }
        /** @var Answer $answer */
        foreach ($answers as $answer) {
            if ($answer instanceof ClozeTerm) {
                $this->terms->attach($answer);
            }
        }

        return $this->terms;
    }

    /**
     *
     * @param Question $question
     * @return array Array containing the word positions
     */
    public function getWordPositions(Question $question)
    {
        /* @var $answer \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeTerm */
        foreach ($this->getTerms($question, true) as $answer) {
            $pos = $answer->getWordPosition($this->getText());
            $this->wordPositions[$pos[0]] = $pos;
            $this->wordPositions[$pos[0]]['title'] = $answer->getTitle();
            $this->wordPositions[$pos[0]]['answer'] = $answer;
        }
        if (is_array($this->wordPositions)) {
            ksort($this->wordPositions);
        }
        return $this->wordPositions;
    }

    /**
     *
     * @param array $resultAnswers
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Question $question
     * @param boolean $withHTML
     * @return string $line
     */
    public function getUserText(
        $resultAnswers,
        \Kennziffer\KeQuestionnaire\Domain\Model\Question $question,
        $withHTML = true
    ) {
        $line = '';
        $rterms = [];

        $text = $this->getText();
        $terms = $this->getTerms($question, true);
        $wordPositions = $this->getWordPositions($question);

        foreach ($terms as $term) {
            foreach ($resultAnswers as $temp_ranswer) {
                if (is_object($temp_ranswer)) {
                    if ($temp_ranswer->getAnswer()->getUid() === $term->getUid()) {
                        $rterms[] = $temp_ranswer;
                    }
                } else {
                    if ((int)$temp_ranswer['answer'] === $term->getUid()) {
                        $rterms[] = $temp_ranswer;
                    }
                }
            }
        }

        $line = '';
        $start = 0;
        foreach ($wordPositions as $wordPosition) {
            foreach ($rterms as $nr => $rterm) {
                if (is_object($rterm)) {
                    if ($rterm->getAnswer()->getUid() === $wordPosition['answer']->getUid()) {
                        $line .= mb_substr($text, $start, $wordPosition[0] - $start);
                        if ($withHTML) {
                            $line .= '<b>' . $rterm->getValue() . '</b>';
                        } else {
                            $line .= $rterm->getValue();
                        }
                        $start = $wordPosition[0] + $wordPosition[1];
                    }
                } else {
                    if ($rterm['answer'] == $wordPosition['answer']->getUid()) {
                        $line .= mb_substr($text, $start, ($wordPosition[0] - $start));
                        if ($withHTML) {
                            $line .= '<b>' . $rterm['value'] . '</b>';
                        } else {
                            $line .= $rterm['value'];
                        }
                        $start = $wordPosition[0] + $wordPosition[1];
                    }
                }
            }
        }
        $line .= mb_substr($text, $start);

        return $line;
    }

    /**
     * Create the whole Csv Line
     * @param array $results
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Question $question
     * @param array options
     * @return string
     */
    public function getCsvLine(
        array $results,
        \Kennziffer\KeQuestionnaire\Domain\Model\Question $question,
        $options = []
    ) {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ResultQuestionRepository $rep */
        $rep = $objectManager->get(ResultQuestionRepository::class);
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $rep->setDefaultQuerySettings($querySettings);

        $aL = [];
        for ($i = 0; $i < $options['emptyFields']; $i++) {
            $aL[] = '';
        }

        $aL[] = $this->getTitle();
        if ($options['showAText']) {
            $aL[] = strip_tags($this->getText());
        }

        foreach ($results as $result) {
            $resultQuestion = $rep->findByQuestionAndResultId($question, $result['uid']);
            $resultQuestion = $resultQuestion[0];
            if ($resultQuestion) {
                $aL[] = $this->getUserText($resultQuestion->getAnswers(), $question, false);
            } else {
                $aL[] = '';
            }
        }
        foreach ($aL as $nr => $value) {
            if (!is_numeric($value)) {
                $aL[$nr] = $options['textMarker'] . $value . $options['textMarker'];
            }
        }
        return implode($options['separator'], $aL) . $options['newline'];
    }
}
