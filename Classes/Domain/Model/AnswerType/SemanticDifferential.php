<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\AnswerType;

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
class SemanticDifferential extends \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Slider
{

    /**
     * pdfType
     *
     * @var string
     */
    protected $pdfType = 'normal';

    /**
     * showsSteps
     *
     * @var boolean
     */
    protected $showSteps;

    /**
     * stepLabels
     *
     * @var string
     */
    protected $stepLabels;

    /**
     * stepPercentage
     *
     * @var int
     */
    protected $stepPercentage;

    /**
     * PointsStart
     *
     * @var string
     */
    protected $pointsStart;

    /**
     * PointsIncrease
     *
     * @var string
     */
    protected $pointsIncrease;

    /**
     * Returns the showSteps
     *
     * @return boolean showSteps
     */
    public function getShowSteps()
    {
        return $this->showSteps;
    }

    /**
     * Sets the showSteps
     *
     * @param boolean $showSteps
     * @return void
     */
    public function setShowSteps($showSteps)
    {
        $this->showSteps = $showSteps;
    }

    /**
     * Returns the stepLabels
     *
     * @return string $stepLabels
     */
    public function getStepLabels()
    {
        return $this->stepLabels;
    }

    /**
     * Sets the stepLabels
     *
     * @param string $stepLabels
     * @return void
     */
    public function setStepLabels($stepLabels)
    {
        $this->stepLabels = $stepLabels;
    }

    /**
     * Returns the stepLabels as array
     *
     * @return array|boolean $stepLabels
     */
    public function getStepLabelsArray()
    {
        $labels = explode(',', $this->stepLabels);
        if ($labels[0] === '') {
            return false;
        }
        return $labels;
    }

    /**
     * Returns the stepLabels as array
     *
     * @return array|boolean $stepLabels
     */
    public function getStepLabelsValuesArray()
    {
        $base = explode(',', $this->stepLabels);
        $steps = $this->getSteps();
        $labels = [];
        foreach ($steps as $nr => $value) {
            $labels[$value] = $base[$nr];
        }
        if (count($labels) === 0) {
            return false;
        }
        return $labels;
    }

    /**
     * Returns the steps
     *
     * @return array steps
     */
    public function getSteps()
    {
        $steps = [];
        for ($i = $this->minValue; $i <= $this->maxValue; $i += $this->sliderIncrement) {
            $steps[] = $i;
        }
        return $steps;
    }

    /**
     * Returns the steps percentage
     *
     * @return int percentage
     */
    public function getStepPercentage()
    {
        $percentage = 0;

        $stepCount = count($this->getSteps());
        $percentage = (100 / $stepCount) - 2.5;

        return $percentage;
    }

    /**
     * Returns the pointsStart
     *
     * @return string $pointsStart
     */
    public function getPointsStart()
    {
        return $this->pointsStart;
    }

    /**
     * Sets the pointsStart
     *
     * @param string $pointsStart
     * @return void
     */
    public function setPointsStart($pointsStart)
    {
        $this->pointsStart = $pointsStart;
    }

    /**
     * Returns the pointsIncrease
     *
     * @return string $pointsIncrease
     */
    public function getPointsIncrease()
    {
        return $this->pointsIncrease;
    }

    /**
     * Sets the pointsIncrease
     *
     * @param string $pointsIncrease
     * @return void
     */
    public function setPointsIncrease($pointsIncrease)
    {
        $this->pointsIncrease = $pointsIncrease;
    }

    /**
     * Returns the points
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $resultAnswer
     * @return string $points
     */
    public function getPoints(\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $resultAnswer = null)
    {
        $points = 0;
        if ($this->getPointsIncrease() > 0) {
            $steps = $this->getSteps();

            $counter = 0;
            foreach ($steps as $step) {
                $counter++;
                if ($step == $resultAnswer->getValue()) {
                    if ($counter > 1) {
                        $points = $this->getPointsStart() + (($counter - 1) * $this->getPointsIncrease());
                    } else {
                        $points = $this->getPointsStart();
                    }
                }
            }
        }
        return $points;
    }

    /**
     * Returns the points
     *
     * @return string $points
     */
    public function getMaxPoints()
    {
        $stepcount = count($this->getSteps());
        $max = $this->getPointsStart() + ($this->getPointsIncrease() * ($stepcount - 1));
    }

}
