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
class SingleInput extends \Kennziffer\KeQuestionnaire\Domain\Model\Answer
{

    /**
     * Width
     *
     * @var integer
     */
    protected $width;

    /**
     * PreText
     *
     * @var string
     */
    protected $preText;

    /**
     * InText
     *
     * @var string
     */
    protected $inText;

    /**
     * PostText
     *
     * @var string
     */
    protected $postText;

    /**
     * MaxChars
     *
     * @var integer
     */
    protected $maxChars;

    /**
     * ValidationType
     *
     * @var string
     */
    protected $validationType;

    /**
     * ValidationText
     *
     * @var string
     */
    protected $validationText;

    /**
     * ValidationKeysAmount
     *
     * @var integer
     */
    protected $validationKeysAmount;

    /**
     * ComparisonText
     *
     * @var string
     */
    protected $comparisonText;

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
     * Returns the preText
     *
     * @return string $preText
     */
    public function getPreText()
    {
        return $this->preText;
    }

    /**
     * Sets the preText
     *
     * @param string $preText
     * @return void
     */
    public function setPreText($preText)
    {
        $this->preText = $preText;
    }

    /**
     * Returns the inText
     *
     * @return string $inText
     */
    public function getInText()
    {
        return $this->inText;
    }

    /**
     * Sets the inText
     *
     * @param string $inText
     * @return void
     */
    public function setInText($inText)
    {
        $this->inText = $inText;
    }

    /**
     * Returns the PostText
     *
     * @return string $postText
     */
    public function getPostText()
    {
        return $this->postText;
    }

    /**
     * Sets the PostText
     *
     * @param string $postText
     * @return void
     */
    public function setPostText($postText)
    {
        $this->postText = $postText;
    }

    /**
     * Returns the maxChars
     *
     * @return integer $maxChars
     */
    public function getMaxChars()
    {
        return $this->maxChars;
    }

    /**
     * Sets the maxChars
     *
     * @param integer $maxChars
     * @return void
     */
    public function setMaxChars($maxChars)
    {
        $this->maxChars = $maxChars;
    }

    /**
     * Returns the validationType
     *
     * @return string $validationType
     */
    public function getValidationType()
    {
        return $this->validationType;
    }

    /**
     * Sets the validationType
     *
     * @param string $validationType
     * @return void
     */
    public function setValidationType($validationType)
    {
        $this->validationType = $validationType;
    }

    /**
     * Returns the validationText
     *
     * @return string $validationText
     */
    public function getValidationText()
    {
        return $this->validationText;
    }

    /**
     * Sets the validationText
     *
     * @param string $validationText
     * @return void
     */
    public function setValidationText($validationText)
    {
        $this->validationText = $validationText;
    }

    /**
     * Returns the validationKeysAmount
     *
     * @return integer $validationKeysAmount
     */
    public function getValidationKeysAmount()
    {
        return $this->validationKeysAmount;
    }

    /**
     * Sets the validationKeysAmount
     *
     * @param integer $validationKeysAmount
     * @return void
     */
    public function setValidationKeysAmount($validationKeysAmount)
    {
        $this->validationKeysAmount = $validationKeysAmount;
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
     * Checks if the value is valid for this answer
     *
     * @param string $value value
     * @return boolean
     */
    public function isValid($value)
    {
        if ($value) {
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
        } else {
            return true;
        }
    }

    /**
     * TODO: needs to be moved to a utility!!!
     * checks if the given value is a daten in the given format
     *
     * @param string $value Value to check
     * @param string $format Format to check
     * @return boolean
     */
    function is_date($value, $format)
    {
        // find separator
        $separator_only = str_replace(['m', 'd', 'y'], '', $format);
        $separator = $separator_only[0]; // separator is first character

        if (!$separator) {
            return false;
        }
        if (substr_count($value, $separator) != 2) {
            return false;
        }

        // check for numbers
        $numbers = explode($separator, $value);

        foreach ($numbers as $number) {
            if (substr_count($number, '.') > 0) {
                return false;
            }
            if (!is_numeric($number)) {
                return false;
            }
        }

        $formatParts = explode($separator, $format);

        $m = 0;
        $d = 0;
        $y = 0;
        for ($i = 0; $i < 3; $i++) {
            if (substr_count($formatParts[$i], 'm') > 0) {
                $m = $numbers[$i];
            }
            if (substr_count($formatParts[$i], 'd') > 0) {
                $d = $numbers[$i];
            }
            if (substr_count($formatParts[$i], 'y') > 0) {
                $y = $numbers[$i];
            }
            if (substr_count($formatParts[$i], 'Y') > 0) {
                $y = $numbers[$i];
            }
        }

        return checkdate($m, $d, $y);
    }
}
