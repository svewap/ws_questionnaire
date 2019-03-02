<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
class ResultQuestion extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * FeCruserId
     *
     * @var integer
     */
    protected $feCruserId;

    /**
     * Answers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer>
     * @cascade remove
     */
    protected $answers;

    /**
     * question
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\Question
     */
    protected $question;

    /**
     * Points
     *
     * @var integer
     */
    protected $points;

    /**
     * MaxPoints
     *
     * @var integer
     */
    protected $maxPoints;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->answers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Checks the ResultAnswers if existent
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer> $answers
     * @return void
     */
    public function checkAnswers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers)
    {
        foreach ($this->getAnswers() as $answer) {
            $this->checkAnswer($answers, $answer);
        }

        if (count($answers) > count($this->getAnswers())) {
            foreach ($answers as $checkAnswer) {
                if ($checkAnswer->getCol() > 0) {
                    $found = false;
                    foreach ($this->getAnswers() as $answer) {
                        if ($answer->getAnswer() === $checkAnswer->getAnswer()
                            AND $answer->getCol() == $checkAnswer->getCol()) {
                            $found = true;
                        }
                    }
                    if (!$found) {
                        $this->addAnswer($checkAnswer);
                    }
                }
            }
        }
    }

    /**
     * Check the Answer in the saving-Process
     * the saveType dertermines if the answers is replaced or the value is replaced. Matrix Answers are worked differently
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $resultAnswer
     */
    public function checkAnswer($answers, &$resultAnswer)
    {
        if ($resultAnswer->getAnswer()) {
            switch ($resultAnswer->getAnswer()->getSaveType()) {
                case 'replaceAnswer':
                    foreach ($answers as $ranswer) {
                        if ($ranswer->getAnswer()->getType() === $resultAnswer->getAnswer()->getType()) {
                            $resultAnswer->setAnswer($ranswer->getAnswer());
                            $resultAnswer->setValue($ranswer->getValue());
                            $resultAnswer->setAdditionalValue($ranswer->getAdditionalValue());
                        }
                    }
                    break;
                case 'matrix':
                    foreach ($answers as $ranswer) {
                        if ($ranswer->getAnswer() === $resultAnswer->getAnswer()) {
                            $mPos = $ranswer->getMatrixPos();
                            if ($resultAnswer->getCol() && $mPos[$resultAnswer->getCol()]) {
                                $resultAnswer->setValue($mPos[$resultAnswer->getCol()]['value']);
                            } else {
                                $resultAnswer->setValue($ranswer->getValue());
                                $resultAnswer->setAdditionalValue($ranswer->getAdditionalValue());
                            }
                        }
                    }
                    break;
                case 'replaceValue':
                default:
                    foreach ($answers as $ranswer) {
                        if ($ranswer->getAnswer() === $resultAnswer->getAnswer()) {
                            $resultAnswer->setValue($ranswer->getValue());
                            $resultAnswer->setAdditionalValue($ranswer->getAdditionalValue());
                        }
                    }
                    break;
            }
        }
    }

    /**
     * Adds a ResultAnswer
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $answer
     * @return void
     */
    public function addAnswer(\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $answer)
    {
        $this->answers->attach($answer);
    }

    /**
     * Removes a ResultAnswer
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $answerToRemove The ResultAnswer to be removed
     * @return void
     */
    public function removeAnswer(\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $answerToRemove)
    {
        $this->answers->detach($answerToRemove);
    }

    /**
     * Returns the answers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer> $answers
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * clears the answers in the resultAnswer.
     * When an answers is withdrawn => checkBox unchecked
     *
     * @return void
     */
    public function clearAnswers()
    {
        foreach ($this->getAnswers() as $rAnswer) {
            $rAnswer->setValue('');
            $rAnswer->setAdditionalValue('');
            $rAnswer->setCol('');
            $rAnswer->setClone(0);
            $rAnswer->setCloneTitle('');
        }
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();
    }

    /**
     * Returns the cloned answers
     *
     * @return array $answers
     */
    public function getClonedAnswers()
    {
        $cloned = [];
        foreach ($this->answers as $answer) {
            if ($answer->getClone() > 0) {
                $cloned[$answer->getClone()]['title'] = $answer->getCloneTitle();
                $cloned[$answer->getClone()][$answer->getCol()] = $answer;
            }
        }
        return $cloned;
    }

    /**
     * Sets the answers
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer> $answers
     * @return void
     */
    public function setAnswers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers)
    {
        $this->answers = $answers;
    }

    /**
     * Returns the question
     *
     * @return \Kennziffer\KeQuestionnaire\Domain\Model\Question $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion(\Kennziffer\KeQuestionnaire\Domain\Model\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Returns the points
     *
     * @return integer $points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Sets the points
     *
     * @param integer $points
     * @return void
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * Returns the maxPoints
     *
     * @return integer $maxPoints
     */
    public function getMaxPoints()
    {
        if ($this->maxPoints == 0 && $this->getQuestion()->getShortType() == 'Question' && method_exists($this->getQuestion(),
                'getMaxPoints')) {
            $this->maxPoints = $this->getQuestion()->getMaxPoints();
        }
        return $this->maxPoints;
    }

    /**
     * Sets the maxPoints
     *
     * @param integer $maxPoints
     * @return void
     */
    public function setMaxPoints($maxPoints)
    {
        $this->maxPoints = $maxPoints;
    }

    /**
     * helper method which checks if this question was answered
     * regardless if they are correct or not
     *
     * return boolean
     */
    public function isAnswered()
    {
        // check for radiobuttons
        if (!$this->getAnswers()->count()) {
            return false;
        }

        // check for checkboxes
        foreach ($this->getAnswers() as $answer) {
            if ($answer->getValue()) {
                return true;
            }
        }
        return false;
    }

    /**
     * helper method to check if this question was answered correctly
     *
     * return boolean
     */
    public function isAnsweredCorrectly()
    {
        if (count($this->getAnswers())) {
            foreach ($this->getAnswers() as $answer) {
                if ($answer->canBeAnsweredCorrectly()) {
                    $answer->setResultquestion($this);
                    if (!$answer->isAnsweredCorrectly()) {
                        return false;
                    }
                }
            }
            return true;
        } else {
            return false;
        }

    }

    /**
     * helper method to check if this question can answered correctly
     *
     * return boolean
     */
    public function canBeAnsweredCorrectly()
    {
        $canBe = false;
        if ($this->getQuestion()->getType() == 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question') {
            if (count($this->getAnswers())) {
                foreach ($this->getAnswers() as $answer) {
                    if ($answer->canBeAnsweredCorrectly()) {
                        $canBe = true;
                    }
                }
            } else {
                $canBe = true;
            }
        }

        return $canBe;
    }
}
