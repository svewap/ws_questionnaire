<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\QuestionType;

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;
use Kennziffer\KeQuestionnaire\Domain\Model\Question as BaseQuestion;
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
class Question extends BaseQuestion
{

    /**
     * Text
     *
     * @var string
     */
    protected $text;

    /**
     * Help Text
     *
     * @var string
     */
    protected $helpText;

    /**
     * Image
     *
     * @var string
     */
    protected $image;

    /**
     * Image position
     *
     * @var string
     */
    protected $imagePosition;

    /**
     * Is mandatory
     *
     * @var boolean
     */
    protected $isMandatory = false;

    /**
     * Have the question to be answered correctly?
     *
     * @var boolean
     */
    protected $mustBeCorrect = false;

    /**
     * Answers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer>
     * @lazy
     */
    protected $answers;

    /**
     * random answers
     *
     * @var boolean
     */
    protected $randomAnswers = false;

    /**
     * Column Count
     *
     * @var integer
     */
    protected $columnCount;

    /**
     * MaxAnswers
     *
     * @var integer
     */
    protected $maxAnswers;

    /**
     * MinAnswers
     *
     * @var integer
     */
    protected $minAnswers;


    /**
     * Returns the text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     *
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Returns the helpText
     *
     * @return string $helpText
     */
    public function getHelpText()
    {
        return $this->helpText;
    }

    /**
     * Sets the helpText
     *
     * @param string $helpText
     * @return void
     */
    public function setHelpText($helpText)
    {
        $this->helpText = $helpText;
    }

    /**
     * Returns the image
     *
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param string $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Returns the imagePosition
     *
     * @return string $imagePosition
     */
    public function getImagePosition()
    {
        return $this->imagePosition;
    }

    /**
     * Sets the imagePosition
     *
     * @param string $imagePosition
     * @return void
     */
    public function setImagePosition($imagePosition)
    {
        $this->imagePosition = $imagePosition;
    }

    /**
     * Returns the isMandatory
     *
     * @return boolean $isMandatory
     */
    public function getIsMandatory()
    {
        // Check if one answer is a DataPrivacy. If yes, the the question is always mandatory
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var AnswerRepository $rep */
        $rep = $objectManager->get(AnswerRepository::class);
        $answers = $rep->findByQuestion($this);
        /** @var Answer $answer */
        foreach ($answers as $answer) {
            if ($answer->getShortType() === 'DataPrivacy') {
                $this->isMandatory = true;
            }
        }
        return (boolean)$this->isMandatory;
    }

    /**
     * Sets the isMandatory
     *
     * @param boolean $isMandatory
     * @return void
     */
    public function setIsMandatory($isMandatory)
    {
        $this->isMandatory = $isMandatory;
    }

    /**
     * Returns the boolean state of isMandatory
     *
     * @return boolean
     */
    public function isIsMandatory()
    {
        return $this->getIsMandatory();
    }

    /**
     * Returns the mustBeCorrect
     *
     * @return boolean $mustBeCorrect
     */
    public function getMustBeCorrect()
    {
        return $this->mustBeCorrect;
    }

    /**
     * Sets the mustBeCorrect
     *
     * @param boolean $mustBeCorrect
     * @return void
     */
    public function setMustBeCorrect($mustBeCorrect)
    {
        $this->mustBeCorrect = $mustBeCorrect;
    }

    /**
     * Returns the boolean state of mustBeCorrect
     *
     * @return boolean
     */
    public function isMustBeCorrect()
    {
        return $this->getMustBeCorrect();
    }

    /**
     * Adds a Answer
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Answer $answer
     * @return void
     */
    public function addAnswer(\Kennziffer\KeQuestionnaire\Domain\Model\Answer $answer)
    {
        $this->answers->attach($answer);
    }

    /**
     * Removes a Answer
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Answer $answerToRemove The Answer to be removed
     * @return void
     */
    public function removeAnswer(\Kennziffer\KeQuestionnaire\Domain\Model\Answer $answerToRemove)
    {
        $this->answers->detach($answerToRemove);
    }

    /**
     * Returns the answers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer> $answers
     */
    public function getAnswers()
    {
        if ($this->isRandomAnswers()) {
            $answers = $this->answers->toArray();
            shuffle($answers);
            return $answers;
        }
        return $this->answers;
    }

    /**
     * Sets the answers
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer> $answers
     * @return void
     */
    public function setAnswers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers)
    {
        $this->answers = $answers;
    }

    /**
     * Returns the randomAnswers
     *
     * @return boolean $randomAnswers
     */
    public function getRandomAnswers()
    {
        return $this->randomAnswers;
    }

    /**
     * Sets the randomAnswers
     *
     * @param boolean $randomAnswers
     * @return void
     */
    public function setRandomAnswers($randomAnswers)
    {
        $this->randomAnswers = $randomAnswers;
    }

    /**
     * Returns the boolean state of randomAnswers
     *
     * @return boolean
     */
    public function isRandomAnswers()
    {
        return $this->getRandomAnswers();
    }

    /**
     * Returns the columnCount
     *
     * @return integer $columnCount
     */
    public function getColumnCount()
    {
        return $this->columnCount;
    }

    /**
     * Returns the columnPercentage
     *
     * @return integer $columnPercent
     */
    public function getColumnPercent()
    {
        return 100 / $this->columnCount;
    }

    /**
     * Sets the columnCount
     *
     * @param integer $columnCount
     * @return void
     */
    public function setColumnCount($columnCount)
    {
        $this->columnCount = $columnCount;
    }

    /**
     * Returns the maxAnswers
     *
     * @return integer $maxAnswers
     */
    public function getMaxAnswers()
    {
        return $this->maxAnswers;
    }

    /**
     * Sets the maxAnswers
     *
     * @param integer $maxAnswers
     * @return void
     */
    public function setMaxAnswers($maxAnswers)
    {
        $this->maxAnswers = $maxAnswers;
    }

    /**
     * Returns the minAnswers
     *
     * @return integer $minAnswers
     */
    public function getMinAnswers()
    {
        return $this->minAnswers;
    }

    /**
     * Sets the minAnswers
     *
     * @param integer $minAnswers
     * @return void
     */
    public function setMinAnswers($minAnswers)
    {
        $this->minAnswers = $minAnswers;
    }

    /**
     * Returns the maxPoints
     *
     * @return integer $maxPoints
     */
    public function getMaxPoints()
    {
        $max = 0;

        foreach ($this->getAnswers() as $answer) {
            switch ($answer->getShortType()) {
                case 'SemanticDifferential':
                    if ($max < $answer->getMaxPoints()) {
                        $max = $answer->getMaxPoints();
                    }
                    break;
                case 'Checkbox':
                    if ($answer->getPoints() > 0) {
                        $max += $answer->getPoints();
                    }
                    break;
                default:
                    if ($max < $answer->getPoints()) {
                        $max = $answer->getPoints();
                    }
                    break;
            }
        }
        return $max;
    }

}
