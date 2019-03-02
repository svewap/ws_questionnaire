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
class Range extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Text
     *
     * @var string
     */
    protected $text;

    /**
     * PointsFrom
     *
     * @var integer
     */
    protected $pointsFrom;

    /**
     * PointsUntil
     *
     * @var integer
     */
    protected $pointsUntil;

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
     * Returns the pointsFrom
     *
     * @return integer $pointsFrom
     */
    public function getPointsFrom()
    {
        return $this->pointsFrom;
    }

    /**
     * Sets the pointsFrom
     *
     * @param integer $pointsFrom
     * @return void
     */
    public function setPointsFrom($pointsFrom)
    {
        $this->pointsFrom = $pointsFrom;
    }

    /**
     * Returns the pointsUntil
     *
     * @return integer $pointsUntil
     */
    public function getPointsUntil()
    {
        return $this->pointsUntil;
    }

    /**
     * Sets the pointsUntil
     *
     * @param integer $pointsUntil
     * @return void
     */
    public function setPointsUntil($pointsUntil)
    {
        $this->pointsUntil = $pointsUntil;
    }

    /**
     * Check if the Points match the Range
     *
     * @param float $points
     * @return boolean
     */
    public function matches($points)
    {
        return ($points >= $this->getPointsFrom() && $points <= $this->getPointsUntil());
    }

}
