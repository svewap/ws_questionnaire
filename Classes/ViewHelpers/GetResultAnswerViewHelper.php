<?php

namespace WapplerSystems\WsQuestionnaire\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use WapplerSystems\WsQuestionnaire\Domain\Model\Result;
use WapplerSystems\WsQuestionnaire\Domain\Model\ResultAnswer;

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
 * get normal resultanswer
 *
 * @package ws_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class GetResultAnswerViewHelper extends AbstractViewHelper
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
     * Returns a requested question from result record
     *
     * @param Result $result
     * @param int $questionUid
     * @param int $answerUid
     * @return null|ResultAnswer
     */
    public function render(Result $result, $questionUid, $answerUid)
    {
        $resultQuestions = $result->getQuestions();
        /* @var $resultQuestion \WapplerSystems\WsQuestionnaire\Domain\Model\ResultQuestion */
        foreach ($resultQuestions as $resultQuestion) {
            if ($resultQuestion->getQuestion() && $questionUid === $resultQuestion->getQuestion()->getUid()) {
                /* @var $resultAnswer \WapplerSystems\WsQuestionnaire\Domain\Model\ResultAnswer */
                foreach ($resultQuestion->getAnswers()->toArray() as $resultAnswer) {
                    if ($resultAnswer->getAnswer() && $answerUid === $resultAnswer->getAnswer()->getUid()) {
                        return $resultAnswer;
                    }
                }
            }
        }
        return null;
    }
}
