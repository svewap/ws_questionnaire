<?php

namespace Kennziffer\KeQuestionnaire\ViewHelpers;

use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingInput;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingOrder;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingTerm;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\Result;
use Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion;
use Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
class RankingTermViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;


    /**
     * Adds the needed Javascript-File to Additional Header Data
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Answer $answer Answer to be rendered
     * @param Question $question the images are in
     * @param string $as The name of the iteration variable
     * @param Result $result
     * @return string
     */
    public function render($answer, $question, $as, $result = null): string
    {
        $terms = $this->getTerms($question, $answer, $result);

        $templateVariableContainer = $this->renderingContext->getVariableProvider();
        if ($question === null) {
            return '';
        }

        //shuffle($images);
        $output = '';
        foreach ($terms as $nr => $element) {
            $templateVariableContainer->add($as, $element);
            $output .= $this->renderChildren();
            $templateVariableContainer->remove($as);
        }
        return $output;
    }

    /**
     * Gets the Images
     *
     * @param Question $question the terms are in
     * @param $header
     * @param Result $result
     * @return array
     */
    public function getTerms($question, $header, $result): array
    {
        $terms = [];

        // workaround for pointer in question, so all following answer-objects are rendered.
        $addIt = false;
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var AnswerRepository $rep */
        $rep = $objectManager->get(AnswerRepository::class);
        $answers = $rep->findByQuestion($question);

        $ranswers = [];
        if ($result) {
            /** @var ResultQuestion $rquestion */
            foreach ($result->getQuestions() as $rquestion) {

                if ($rquestion->getQuestion()->getUid() === $question->getUid()) {
                    foreach ($rquestion->getAnswers() as $ranswer) {
                        $ranswers[$ranswer->getAnswer()->getUid()] = $ranswer->getValue();
                    }
                }
            }
        }
        ksort($ranswers);

        $counter = 0;
        foreach ($answers as $answer) {
            //Add only after the correct Matrix-Header is found, only following rows will be added.
            if ($answer instanceof RankingInput) {
                $addIt = false;
                if ($answer === $header) {
                    $addIt = true;
                }
            }
            if ($addIt && $answer instanceof RankingTerm) {
                $counter++;
                if ($answer->getOrder() === 0) {
                    $answer->setOrder($counter);
                }
                if ($answer instanceof RankingOrder) {
                    if ($ranswers[$answer->getUid()]) {
                        $answer->setOrder($ranswers[$answer->getUid()]);
                    }
                    $terms[$answer->getOrder()] = $answer;
                } else {
                    if ($answer->getOrder() === 0) {
                        $answer->setOrder($counter);
                    }
                    $terms[] = $answer;
                }
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
