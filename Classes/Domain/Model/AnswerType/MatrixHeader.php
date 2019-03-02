<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\AnswerType;

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;
use Kennziffer\KeQuestionnaire\Domain\Model\Question;
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
 *  it under the rows of the GNU General Public License as published by
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
class MatrixHeader extends Answer
{
    /**
     * Cols
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer>
     * @lazy
     */
    protected $cols;

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
     * addClones
     *
     * @var boolean
     */
    protected $addClones;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Adds a Col
     *
     * @param Answer $col
     * @return void
     */
    public function addCol(Answer $col)
    {
        $this->cols->attach($col);
    }

    /**
     * Removes a Col
     *
     * @param Answer $colToRemove The Col to be removed
     * @return void
     */
    public function removeCol(Answer $colToRemove)
    {
        $this->cols->detach($colToRemove);
    }

    /**
     * Returns the cols
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer> $cols
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * Sets the cols
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Answer> $cols
     * @return void
     */
    public function setCols(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $cols)
    {
        $this->cols = $cols;
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
        if ($options['rows']) {
            $rows = $options['rows'];
        } else {
            $rows = $this->getRows($question);
        }
        $line = '';


        foreach ($rows as $row) {
            $aL = [];
            for ($i = 0; $i < $options['emptyFields']; $i++) {
                $aL[] = '';
            }

            $aL[] = $row->getTitle();
            if ($options['showAText']) {
                $aL[] = strip_tags($row->getText());
            }

            $line .= implode($options['separator'], $aL) . $options['newline'];
            if (!$row->isTitleLine()) {
                foreach ($this->getCols() as $column) {
                    $aL = [];
                    for ($i = 0; $i < $options['emptyFields']; $i++) {
                        $aL[] = '';
                    }
                    $aL[] = $column->getTitle();
                    if ($options['showAText']) {
                        $aL[] = strip_tags($column->getText());
                    }

                    foreach ($results as $result) {
                        //TODO:
                        //if ($column->getShortType() == 'Radiobutton' && !$options['extended']) $rAnswer = $result->getAnswer($question->getUid(), $row->getUid(), 0);
                        //else $rAnswer = $result->getAnswer($question->getUid(), $row->getUid(), $column->getUid());
                        $options['row'] = $row;
                        if ($rAnswer) {
                            $aL[] = $column->getCsvValue($rAnswer, $options);
                        } else {
                            $aL[] = '';
                        }
                    }

                    foreach ($aL as $nr => $value) {
                        if (!is_numeric($value)) {
                            $aL[$nr] = $this->text . $value . $this->text;
                        }
                    }

                    $line .= implode($options['separator'], $aL) . $options['newline'];
                }
            }
        }
        return $line;
    }

    /**
     * Create the header of the line
     * @param Question $question
     * @param array options
     * @return string
     */
    public function getCsvLineHeader(Question $question, $options = [])
    {
        if ($options['rows']) {
            $rows = $options['rows'];
        } else {
            $rows = $this->getRows($question);
        }
        $line = '';

        foreach ($rows as $row) {
            $aL = [];
            for ($i = 0; $i < $options['emptyFields']; $i++) {
                $aL[] = '';
            }

            $aL[] = $row->getTitle();
            if ($options['showAText']) {
                $aL[] = strip_tags($row->getText());
            }

            $line .= implode($options['separator'], $aL) . $options['newline'];
            if (!$row->isTitleLine()) {
                foreach ($this->getCols() as $column) {
                    $aL = [];
                    for ($i = 0; $i < $options['emptyFields']; $i++) {
                        $aL[] = '';
                    }
                    $aL[] = $column->getTitle();
                    if ($options['showAText']) {
                        $aL[] = strip_tags($column->getText());
                    }

                    $line .= implode($options['separator'], $aL) . $options['newline'];
                }
            }
        }
        return $line;
    }


    /**
     * Create the data of the Csv Line
     * @param array $results
     * @param Question $question
     * @param array options
     * @param array oldArray
     * @param integer counter
     * @return string
     */
    public function getCsvLineValues(
        array $results,
        Question $question,
        $options = []
    ) {
        if ($options['rows']) {
            $rows = $options['rows'];
        } else {
            $rows = $this->getRows($question);
        }
        $line = '';

        foreach ($rows as $row) {
            $line .= $options['newline'];
            $aL = [];
            if (!$row->isTitleLine()) {
                foreach ($this->getCols() as $column) {
                    $aL = [];
                    foreach ($results as $result) {
                        if (!$options['extended'] && $column->getShortType() === 'Radiobutton') {
                            $rAnswer = $result->getAnswer($question->getUid(), $row->getUid(), 0);
                        } else {
                            $rAnswer = $result->getAnswer($question->getUid(), $row->getUid(), $column->getUid());
                        }
                        $options['row'] = $row;
                        if ($rAnswer) {
                            $aL[] = $column->getCsvValue($rAnswer, $options);
                        } else {
                            $aL[] = '';
                        }
                    }

                    foreach ($aL as $nr => $value) {
                        if (!is_numeric($value)) {
                            $aL[$nr] = $this->text . $value . $this->text;
                        }
                    }

                    if (is_array($aL)) {
                        //implode the csv
                        $line .= implode($options['separator'], $aL) . $options['newline'];
                    }
                }
            }
        }
        return $line;
    }


    /**
     * Gets the Rows
     *
     * @param Question $question the rows are in
     * @return Answer[]
     */
    public function getRows(Question $question)
    {
        $rows = [];

        // workaround for pointer in question, so all following answer-objects are rendered.
        $addIt = false;
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var AnswerRepository $rep */
        $rep = $objectManager->get(AnswerRepository::class);
        $answers = $rep->findByQuestionWithoutPid($question);

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            //Add only after the correct Matrix-Header is found, only following rows will be added.
            // TODO: Fix
            if ($answer instanceof self && $answer === $this) {
                $addIt = true;
            } elseif ($answer instanceof self) {
                $addIt = false;
            }
            if ($addIt && $answer instanceof MatrixRow) {
                $rows[] = $answer;
            }
        }

        return $rows;
    }

    /**
     * get clone-Row
     *
     * @param Question $question the rows are in
     * @return MatrixRow $row
     */
    public function getCloneableRow(Question $question)
    {
        $rows = $this->getRows($question);
        return $rows[count($rows) - 1];
    }

    /**
     * Returns the addClones
     *
     * @return boolean addClones
     */
    public function getAddClones()
    {
        return (boolean)$this->addClones;
    }

    /**
     * Sets the addClones
     *
     * @param boolean $addClones
     * @return void
     */
    public function setAddClones($addClones)
    {
        $this->addClones = $addClones;
    }

}
