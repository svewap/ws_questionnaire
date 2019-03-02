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
class SingleSelect extends \Kennziffer\KeQuestionnaire\Domain\Model\Answer
{

    /**
     * SelectValues
     *
     * @var string
     */
    protected $selectValues;

    /**
     * ComparisonText
     *
     * @var string
     */
    protected $comparisonText;

    /**
     * Returns the selectValues
     *
     * @return string $selectValues
     */
    public function getSelectValues()
    {
        return $this->selectValues;
    }

    /**
     * Sets the selectValues
     *
     * @param string $selectValues
     * @return void
     */
    public function setSelectValues($selectValues)
    {
        $this->selectValues = $selectValues;
    }

    /**
     * Returns the selectValues as array
     *
     * @return array $selectValues
     */
    public function getSelectValuesArray()
    {
        $values = [];
        foreach (explode("\n", $this->selectValues) as $line) {
            $temp = explode(':', $line);
            if ($temp[1] == '') {
                $temp[1] = $temp[0];
            }
            $values[trim($temp[0])] = trim($temp[1]);
        }

        return $values;
    }

    /**
     * Returns the comparitionText
     *
     * @return string $comparisonText
     */
    public function getComparisonText()
    {
        return $this->comparisonText;
    }

    /**
     * Sets the comparisonText
     *
     * @param string $comparisonText
     * @return void
     */
    public function setComparisonText($comparisonText)
    {
        $this->comparisonText = $comparisonText;
    }

    /**
     * Returns the comparisonText as array
     *
     * @return array
     */
    public function getComparisonTextArray()
    {
        $values = [];
        foreach (explode("\n", $this->comparisonText) as $line) {
            $temp = explode(':', $line);
            if ($temp[1] === '') {
                $temp[1] = $temp[0];
            }
            $values[trim($temp[0])] = trim($temp[1]);
        }

        return $values;
    }

    /**
     * Checks if the value is valid for this answer
     *
     * @param string $value value
     * @return boolean
     */
    public function isValid($value)
    {
        $class = 'Kennziffer\\KeQuestionnaire\\Validation\\' . ucfirst($this->getValidationType());
        if (class_exists($class)) {
            $objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager;
            $validator = $objectManager->get($class);
            if ($validator instanceof \Kennziffer\KeQuestionnaire\Validation\AbstractValidation) {
                /* @var $validator \Kennziffer\KeQuestionnaire\Validation\AbstractValidation */
                return $validator->isValid($value, $this);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
