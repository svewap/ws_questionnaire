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
class Chart extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Width
     *
     * @var integer
     */
    protected $width;

    /**
     * Height
     *
     * @var integer
     */
    protected $height;

    /**
     * Data
     *
     * @var array
     */
    protected $data;

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
     * Returns the width
     *
     * @return integer $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the width
     *
     * @param integer $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Returns the height
     *
     * @return integer $height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets the height
     *
     * @param integer $height
     * @return void
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Returns the data
     *
     * @param string $varName
     * @param string $outerWrap
     * @param string $innerWrap
     * @return array $data
     */
    public function getData($varName = 'chartData', $outerWrap = '[|]', $innerWrap = '[|]')
    {
        return $this->data;
    }

    /**
     * Sets the data
     *
     * @param array $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Add a data row
     * If an array entry exists $value will be added to this entry
     * If not $value will be the new value of the array entry
     *
     * @param string $title
     * @param integer $value
     * @return void
     */
    public function addData($title, $value = 1)
    {
        if (isset($this->data[$key])) {
            $this->data[$key] += $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    public function getVariables()
    {
        return '
			var title = ' . $this->title . ';' . chr(10) . '
			var width = ' . $this->width . ';' . chr(10) . '
			var height = ' . $this->height . ';' . chr(10) . '
			var chartData = ' . $this->getData() . ';' . chr(10) . '
		';
    }

}
