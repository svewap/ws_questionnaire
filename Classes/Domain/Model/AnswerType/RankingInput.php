<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\AnswerType;

use Kennziffer\KeQuestionnaire\Domain\Model\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\Result;
use Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer;
use Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion;
use Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultAnswerRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultQuestionRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

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
class RankingInput extends DDAreaSequence
{
    /**
     * pdfType
     *
     * @var string
     */
    protected $pdfType = 'normal';

    /**
     * Get the Ranking-Order as string
     *
     * @param Result $result
     * @param Question $question
     *
     * @return string line for Analysis
     */
    public function getRankingLine(
        Result $result,
        Question $question
    ) {
        $line = [];

        $terms = $this->getTerms($question, $result);
        foreach ($terms as $term) {
            $line[$term->getOrder()] = $term->getTitle();
        }
        return implode(', ', $line);
    }

    /**
     * Gets the Images
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question $question the terms are in
     * @param Result $result
     * @return array
     */
    public function getTerms($question, $result)
    {
        $terms = [];

        // workaround for pointer in question, so all following answer-objects are rendered.
        $addIt = false;
        $type = '';
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
        /** @var AnswerRepository $rep */
        $rep = $objectManager->get(AnswerRepository::class);
        /** @var ResultQuestionRepository $repRQ */
        $repRQ = $objectManager->get(ResultQuestionRepository::class);
        /** @var ResultAnswerRepository $repRQA */
        $repRQA = $objectManager->get(ResultAnswerRepository::class);
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $rep->setDefaultQuerySettings($querySettings);
        $repRQ->setDefaultQuerySettings($querySettings);
        $repRQA->setDefaultQuerySettings($querySettings);
        $answers = $rep->findByQuestion($question);
        $ranswers = [];
        if ($result) {
            $rQuestions = $repRQ->findByResult($result);
            /** @var ResultQuestion $rquestion */
            foreach ($rQuestions as $rquestion) {
                if ($rquestion->getQuestion()->getUid() === $question->getUid()) {
                    $rQAnswers = $repRQA->findByResultquestion($rquestion);
                    /** @var ResultAnswer $ranswer */
                    foreach ($rQAnswers as $ranswer) {
                        $ranswers[$ranswer->getAnswer()->getUid()] = $ranswer->getValue();
                    }
                }
            }
        }
        ksort($ranswers);
        $counter = 0;
        foreach ($answers as $answer) {
            //Add only after the correct Header is found, only following rows will be added.
            if ((
                    get_class($answer) === 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingInput' ||
                    $answer instanceof \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingSelect ||
                    $answer instanceof \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingOrder
                ) && $answer === $this) {
                $addIt = true;
                $type = get_class($answer);
            } elseif (get_class($answer) === 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingInput' ||
                $answer instanceof \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingSelect ||
                $answer instanceof \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingOrder) {
                $addIt = false;
            }
            if ($addIt && $answer instanceof \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingTerm) {
                $counter++;
                if ($answer->getOrder() == 0) {
                    $answer->setOrder($counter);
                }
                if ($ranswers[$answer->getUid()]) {
                    $answer->setOrder($ranswers[$answer->getUid()]);
                }
                $terms[$answer->getOrder()] = $answer;
            }
        }
        $selectItems = [];
        for ($i = 0; $i < $counter; $i++) {
            $selectItems[$i + 1] = $i + 1;
        }
        foreach ($terms as $nr => $term) {
            $terms[$nr]->setSelectItems($selectItems);
        }
        ksort($terms);
        return $terms;
    }
}
