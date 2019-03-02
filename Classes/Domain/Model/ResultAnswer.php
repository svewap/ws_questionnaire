<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model;

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
class ResultAnswer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * FeCruserId
     *
     * @var integer
     */
    protected $feCruserId;

    /**
     * Answer
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\Answer
     */
    protected $answer;

    /**
     * Resultquestion
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion
     */
    protected $resultquestion;

    /**
     * Value
     *
     * @var string
     */
    protected $value;

    /**
     * arrayValue
     *
     * @var array
     */
    protected $arrayValue;

    /**
     * Col
     *
     * @var string
     */
    protected $col;

    /**
     * Clone
     *
     * @var string
     */
    protected $clone;

    /**
     * CloneTitle
     *
     * @var string
     */
    protected $cloneTitle;

    /**
     * AdditionalValue
     *
     * @var string
     */
    protected $additionalValue;

    /**
     * matrixPos
     *
     * @var array
     */
    protected $matrixPos;

    /**
     * cloned
     *
     * @var array
     */
    protected $cloned;


    /**
     * each model needs an constructor:
     * http://wiki.typo3.org/Exception/v4/1297759968
     */
    public function __construct()
    {
    }

    /**
     * Returns the feCruserId
     *
     * @return integer $feCruserId
     */
    public function getFeCruserId()
    {
        return $this->feCruserId;
    }

    /**
     * Sets the feCruserId
     *
     * @param integer $feCruserId
     * @return void
     */
    public function setFeCruserId($feCruserId)
    {
        $this->feCruserId = $feCruserId;
    }

    /**
     * Returns the answer
     *
     * @return \Kennziffer\KeQuestionnaire\Domain\Model\Answer $answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the answer
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Answer $answer
     * @return void
     */
    public function setAnswer(\Kennziffer\KeQuestionnaire\Domain\Model\Answer $answer)
    {
        $this->answer = $answer;

        // radio buttons need some special part here. This is a templating problem.
        // if we add for each radiobutton a hidden field for the value col, we have more than one entry in DB
        // so this is only solveable if we add ONE hidden field for ALL radiobuttons.
        // if you can fix this with JavaScript then you can remove this part.
        if ($this->getAnswer()->getType() === 'Kennziffer\\KeQuestionnaire\\Domain\\Model\\AnswerType\\Radiobutton') {
            $this->setValue($this->getAnswer()->getUid());
        }
    }

    /**
     * Returns the resultquestion
     *
     * @return \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion $resultquestion
     */
    public function getResultquestion()
    {
        return $this->resultquestion;
    }

    /**
     * Sets the resultquestion
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion $resultquestion
     * @return void
     */
    public function setResultquestion(\Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion $resultquestion)
    {
        $this->resultquestion = $resultquestion;
    }

    /**
     * Returns the value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value
     *
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value
     *
     * @return array
     */
    public function getArrayValue()
    {
        return $this->arrayValue;
    }

    /**
     * Sets the value
     *
     * @param array $value
     * @return void
     */
    public function setArrayValue($value)
    {
        $this->arrayValue = $value;
    }

    /**
     * helper method to check if this answer was answered correctly
     *
     * @return boolean
     */
    public function isAnsweredCorrectly()
    {
        switch ($this->getAnswer()->getShortType()) {
            case 'Checkbox':
                //get correct answers. It is possible to have multiple correct answer
                $answers = $this->getResultquestion()->getQuestion()->getAnswers();
                $correctAnswersUids = [];
                foreach ($answers as $answer) {
                    /** @var $answer \Kennziffer\KeQuestionnaire\Domain\Model\Answer */
                    if ($answer->getIsCorrectAnswer()) {
                        $correctAnswersUids[] = (int)$answer->getUid();
                    }
                }
                array_unique($correctAnswersUids);
                sort($correctAnswersUids);

                /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer> $resultAnswers */
                $resultAnswers = $this->getResultquestion()->getAnswers();
                $resultAnswerUids = [];
                foreach ($resultAnswers as $resultAnswer) {
                    /** @var $resultAnswer \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer */
                    if ($resultAnswer->getValue()) {
                        $resultAnswerUids[] = (int)$resultAnswer->getValue();
                    }
                }
                array_unique($resultAnswerUids);
                sort($resultAnswerUids);

                //Compare result answers with correct answers
                if ($correctAnswersUids === $resultAnswerUids) {
                    //When all result answers match to correct answers
                    //we send tru only for 1st answer to avoid duplication

                    return true;
                    //$firstAnswer = array_shift($resultAnswerUids);
                    //if( intval($this->getValue()) ==  $firstAnswer ) return true;
                    //else return false;
                } else {
                    return false;
                }
                break;
            case 'Radiobutton':
                return $this->getAnswer()->getIsCorrectAnswer();
            case 'SingleInput':
            case 'MultiInput':
                return $this->getAnswer()->isValid($this->getValue());
            case 'SingleSelect':
                $correctAnswers = $this->getAnswer()->getComparisonTextArray();
                if (\in_array($this->getValue(), $correctAnswers) || isset($correctAnswers[$this->getValue()])) {
                    return true;
                }
                return
                    false;
                break;
            case 'ClozeText':
            case 'ClozeTextDD':
                if ($this->getAnswer()->getUserText($this->getResultquestion()->getAnswers(),
                        $this->getResultquestion()->getQuestion(), false) == $this->getAnswer()->getText()) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'DDImage':
                if ($this->getAnswer()->getAreaIndex() == $this->getValue()) {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * helper method to check if this answer can be answered correctly
     *
     * @return boolean
     */
    public function canBeAnsweredCorrectly()
    {
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->getAnswer()->getType(), 'result');
        switch ($this->getAnswer()->getShortType()) {
            case 'Checkbox':
            case 'Radiobutton':
            case 'SingleSelect':
            case 'ClozeText':
            case 'ClozeTextDD':
            case 'DDImage':
                return true;
                break;
            case 'SingleInput':
            case 'MultiInput':
                return ($this->getAnswer()->getValidationType() === 'compareText' || $this->getAnswer()->getValidationType() === 'keywords');
            default:
                // no correct answer possible
                return false;
                break;
        }
    }

    /**
     * Returns the col
     *
     * @return string $col
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * Sets the col
     *
     * @param string $col
     * @return void
     */
    public function setCol($col)
    {
        $this->col = $col;
    }

    /**
     * Returns the clone
     *
     * @return string $clone
     */
    public function getClone()
    {
        return $this->clone;
    }

    /**
     * Sets the clone
     *
     * @param string $clone
     * @return void
     */
    public function setClone($clone)
    {
        $this->clone = $clone;
    }

    /**
     * Returns the cloneTitle
     *
     * @return string $cloneTitle
     */
    public function getCloneTitle()
    {
        return $this->cloneTitle;
    }

    /**
     * Sets the cloneTitle
     *
     * @param string $cloneTitle
     * @return void
     */
    public function setCloneTitle($cloneTitle)
    {
        $this->cloneTitle = $cloneTitle;
    }

    /**
     * Returns the additionalValue
     *
     * @return string $additionalValue
     */
    public function getAdditionalValue()
    {
        return $this->additionalValue;
    }

    /**
     * Sets the additionalValue
     *
     * @param string $additionalValue
     * @return void
     */
    public function setAdditionalValue($additionalValue)
    {
        $this->additionalValue = $additionalValue;
    }

    /**
     * Returns the matrixPos
     *
     * @return array $matrixPos
     */
    public function getMatrixPos()
    {
        return $this->matrixPos;
    }

    /**
     * Sets the matrixPos
     *
     * @param array $matrixPos
     * @return void
     */
    public function setMatrixPos($matrixPos)
    {
        $this->matrixPos = $matrixPos;
    }

    /**
     * Returns the cloned
     *
     * @return array $cloned
     */
    public function getCloned()
    {
        return $this->cloned;
    }

    /**
     * Sets the cloned
     *
     * @param array $cloned
     * @return void
     */
    public function setCloned($cloned)
    {
        $this->cloned = $cloned;
    }

    /**
     * Returns the points
     *
     * @return string
     */
    public function getPoints()
    {
        switch ($this->getAnswer()->getShortType()) {
            case 'SemanticDifferential':
                return $this->getAnswer()->getPoints($this);
                break;
            case 'Checkbox':
                if ((int)$this->getValue() === $this->getAnswer()->getUid()) {
                    return $this->getAnswer()->getPoints();
                }
                break;
            default:
                return $this->getAnswer()->getPoints();
                break;
        }
    }
}
