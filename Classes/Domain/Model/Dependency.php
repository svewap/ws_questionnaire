<?php

namespace WapplerSystems\WsQuestionnaire\Domain\Model;

use WapplerSystems\WsQuestionnaire\Domain\Repository\QuestionRepository;
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
 * @package ws_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Dependency extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * answer
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Model\Answer
     */
    protected $answer;

    /**
     * question
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Model\Question
     */
    protected $question;

    /**
     * dquestion
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Model\Question
     */
    protected $dquestion;

    /**
     * relation
     *
     * @var string
     */
    protected $relation;

    /**
     * Returns the answer
     *
     * @return \WapplerSystems\WsQuestionnaire\Domain\Model\Answer $answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the answer
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Answer $answer
     * @return void
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Returns the question
     *
     * @return \WapplerSystems\WsQuestionnaire\Domain\Model\Question $question
     */
    public function getQuestion()
    {
        if (!$this->question) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $q_rep = $this->objectManager->get(QuestionRepository::class);
            $this->question = $q_rep->findByUid($this->answer->getQuestion());
        }
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Returns the dQuestion
     *
     * @return \WapplerSystems\WsQuestionnaire\Domain\Model\Question $dQuestion
     */
    public function getDQuestion()
    {
        return $this->dQuestion;
    }

    /**
     * Sets the dQuestion
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Question $dQuestion
     * @return void
     */
    public function setDQuestion($dQuestion)
    {
        $this->dQuestion = $dQuestion;
    }

    /**
     * Returns the relation
     *
     * @return string $relation
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Sets the relation
     *
     * @param string $relation
     * @return void
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    /**
     * creates the JS to be used in the CheckDependenciesViewHelper
     *
     * @param integer $nr
     * @return string
     */
    public function getRelationJs($nr)
    {
        $js = '';

        if ($nr > 1) {
            switch ($this->getRelation()) {
                case 'and':
                    $js .= '&& (';
                    break;
                case 'or':
                    $js .= '|| (';
                    break;
                default :
                    $js .= '(';
                    break;
            }
        } else {
            $js .= '(';
        }

        switch ($this->getAnswer()->getShortType()) {
            case 'Radiobutton':
                $js .= 'jQuery("input[name=\'tx_wsquestionnaire_questionnaire[newResult][questions][' . $this->getQuestion()->getUid() . '][answers][' . $this->getQuestion()->getUid() . '][answer]\']:checked").val() == ' . $this->getAnswer()->getUid();
                break;
            default:
                $js .= 'jQuery("input[name=\'tx_wsquestionnaire_questionnaire[newResult][questions][' . $this->getQuestion()->getUid() . '][answers][' . $this->getAnswer()->getUid() . '][value]\']:checked").val() == ' . $this->getAnswer()->getUid();
                break;
        }
        $js .= ')';

        return $js;
    }

    /**
     * creates the Condition-Check to be used in the CheckDependenciesViewHelper
     *
     * @return array
     */
    public function getRelationCondition()
    {
        $condition = [];
        $condition['type'] = $this->getRelation();
        $condition['compareToQuestion'] = $this->getQuestion()->getUid();
        $condition['compareToAnswer'] = $this->getAnswer()->getUid();
        $condition['answerType'] = $this->getAnswer()->getShortType();

        return $condition;
    }

}
