<?php

namespace Kennziffer\KeQuestionnaire\ViewHelpers;

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
 * check the text and create the cloze-text display
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ClozeTextViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeText $answer Answer to be rendered
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question $question the terms are in
     * @param string $as The name of the iteration variable
     * @return string
     */
    public function render($answer, $question, $as)
    {
        $templateVariableContainer = $this->renderingContext->getVariableProvider();
        if ($question === null || ($answer->getShortType() != 'ClozeText' && $answer->getShortType() != 'ClozeTextDD')) {
            return '';
        }

        //$textArray = $this->getClozeTextArray($answer->getText(), $question);
        $wordPositions = $answer->getWordPositions($question);
        $text = $answer->getText();
        $content = '';
        $start = 0;
        if (is_array($wordPositions)) {
            foreach ($wordPositions as $id => $wordPosition) {
                if ($id) {
                    $content .= mb_substr($text, $start, ($wordPosition[0] - $start));
                    $templateVariableContainer->add($as, $wordPosition['answer']);
                    $content .= $this->renderChildren();
                    $templateVariableContainer->remove($as);
                    $start = $wordPosition[0] + $wordPosition[1];
                }
            }
        }
        $content .= mb_substr($text, $start);
        return $content;
    }
}
