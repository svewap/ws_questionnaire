<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model;

use Kennziffer\KeQuestionnaire\Domain\Repository\ResultAnswerRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultQuestionRepository;
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
 * base Type for answers
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Type
     *
     * @var string
     */
    protected $type;

    /**
     * pdfType
     *
     * @var string
     */
    protected $pdfType = 'normal';

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Points
     *
     * @var string
     */
    protected $points;

    /**
     * Text
     *
     * @var string
     */
    protected $text;

    /**
     * Is correct answer
     *
     * @var boolean
     */
    protected $isCorrectAnswer;

    /**
     * questionid
     *
     * @var integer
     */
    protected $question;

    /**
     * Template
     *
     * @var string
     */
    protected $template;

    /**
     * saveType
     *
     * @var string
     */
    protected $saveType;


    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the short version of type
     * type is the complete class name, but for partials it's better to have shorter type names
     *
     * @return string $shortType
     */
    public function getShortType()
    {
        return substr(strrchr($this->type, '\\'), 1);
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getPdfType()
    {
        return $this->pdfType;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the points
     * @param ResultAnswer $resultAnswer
     * @return string $points
     */
    public function getPoints(ResultAnswer $resultAnswer = null)
    {
        return $this->points;
    }

    /**
     * Sets the points
     *
     * @param string $points
     * @return void
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

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
     * Returns the isCorrectAnswer
     *
     * @return boolean isCorrectAnswer
     */
    public function getIsCorrectAnswer()
    {
        return $this->isCorrectAnswer;
    }

    /**
     * Returns the isCorrectAnswer
     *
     * @return boolean isCorrectAnswer
     */
    public function isCorrectAnswer()
    {
        return (boolean)$this->isCorrectAnswer;
    }

    /**
     * Sets the isCorrectAnswer
     *
     * @param boolean $isCorrectAnswer
     * @return void
     */
    public function setIsCorrectAnswer($isCorrectAnswer)
    {
        $this->isCorrectAnswer = $isCorrectAnswer;
    }

    /**
     * Check if this type of answer should be shown in the Csv Export
     * @return boolean
     */
    public function exportInCsv()
    {
        return true;
    }

    /**
     * Create the header of the line
     * @param Question $question
     * @param array options
     * @return string
     */
    public function getCsvLineHeader(Question $question, $options = [])
    {
        $aL = [];
        $addL = [];
        $hasAddL = false;
        //start-columns of the line
        for ($i = 0; $i < $options['emptyFields']; $i++) {
            $aL[] = '';
        }
        //title of answer
        $aL[] = $this->getTitle();
        //if the answer-text should be shown
        if ($options['showAText']) {
            $aL[] = strip_tags($this->getText());
        }

        return implode($options['separator'], $aL) . $options['separator'];
    }

    /**
     * Create the data of the Csv Line
     * @param array $results
     * @param Question $question
     * @param array options
     * @return string
     */
    public function getCsvLineValues(
        array $results,
        Question $question,
        $options = []
    ) {
        $line = '';
        //for each results get the values
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ResultAnswerRepository $repRA */
        $repRA = $objectManager->get(ResultAnswerRepository::class);
        /** @var ResultQuestionRepository $repRQ */
        $repRQ = $objectManager->get(ResultQuestionRepository::class);
        /** @var Result $result */
        foreach ($results as $result) {
            // $rAnswer = $result->getAnswer($question->getUid(), $this->getUid());
            $rQuestion = $repRQ->findByQuestionAndResultIdRaw($question, $result['uid']);
            // $rAnswer = $repRA->findForResultQuestionRaw($rQuestion[0]['uid'] );
            //JVE: Jörg velletti BUG
            $rAnswer = $repRA->findForResultQuestionAndAnswerRaw($rQuestion[0]['uid'], $this->getUid());

            $rAnswer = $rAnswer[0];
            if ($rAnswer) {
                $aL[] = $this->getCsvValueRaw($rAnswer, $options);
                if ($rAnswer && $rAnswer['additionalValue']) {
                    $addL[count($aL) - 1] = $rAnswer['additionalValue'];
                    $hasAddL = true;
                }
            } else {
                $aL[] = '';
            }
        }
        if (is_array($aL)) {
            //insert text-markers
            foreach ($aL as $nr => $value) {
                if (!is_numeric($value)) {
                    $aL[$nr] = $options['textMarker'] . $value . $options['textMarker'];
                }
            }
            //implode the csv
            $line = implode($options['separator'], $aL) . $options['newline'];
            //if there is additional text add a line
            if ($hasAddL) {
                $addLine = [];
                foreach ($aL as $nr => $value) {
                    if ($addL[$nr]) {
                        if (!is_numeric($addL[$nr])) {
                            $addLine[] = $options['textMarker'] . $addL[$nr] . $options['textMarker'];
                        }
                    } else {
                        $addLine[] = '';
                    }

                }
                $line .= implode($options['separator'], $addLine);
            }
        }

        return $line;
    }

    /**
     * Create the whole Csv Line
     * @param array $results
     * @param Question $question
     * @param array options
     * @return string
     */
    public function getCsvLine(
        array $results,
        Question $question,
        $options = []
    ) {

        $line = $this->getCsvLineHeader($question, $options);
        $line .= $this->getCsvLineValues($results, $question, $options);

        return $line;
    }

    /**
     * return the Value shown in the Csv Export
     * @param ResultAnswer $rAnswer
     * @param array $options
     * @return string
     */
    public function getCsvValue(ResultAnswer $rAnswer, $options = [])
    {
        return $rAnswer->getValue();
    }

    /**
     * return the Value shown in the Csv Export
     * @param array $rAnswer
     * @param array $options
     * @return string
     */
    public function getCsvValueRaw(array $rAnswer, $options = [])
    {
        return $rAnswer['value'];
    }

    /**
     * return the id of the Question
     *
     * return integer
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Returns the template
     *
     * @return string $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets the template
     *
     * @param string $template
     * @return void
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Returns the saveType
     *
     * @return string $saveTxpe
     */
    public function getSaveType()
    {
        return 'replaceValue';
    }
}
