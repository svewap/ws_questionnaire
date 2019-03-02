<?php

namespace Kennziffer\KeQuestionnaire\ViewHelpers;

use Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion;

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
 * check if the question is answered
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CheckAnsweredQuestionViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Question $question
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result
     * @return mixed The finally rendered child nodes.
     */
    public function render(
        \Kennziffer\KeQuestionnaire\Domain\Model\Question $question,
        \Kennziffer\KeQuestionnaire\Domain\Model\Result $result
    ) {
        /** @var ResultQuestion $rQuestion */
        foreach ($result->getQuestions() as $rQuestion) {
            if ($rQuestion->getQuestion() === $question) {
                /** @var \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $rAnswer */
                foreach ($rQuestion->getAnswers() as $rAnswer) {
                    if ($rAnswer->getValue() !== '') {
                        return $this->renderChildren();
                    }
                }
            }
        }
    }

}
