<?php

namespace Kennziffer\KeQuestionnaire\Validation;

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
class Date extends AbstractValidation
{

    /**
     * Check if $value is valid.
     *
     * @param mixed $value The value which has to be valid
     * @param object $model the parent model
     * @return boolean
     */
    public function isValid($value, $model)
    {
        return $this->validateDate($value, $model->pattern);
    }

    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $version = explode('.', PHP_VERSION);
        if (((int)$version[0] >= 5 && (int)$version[1] >= 2 && (int)$version[2] > 17)) {
            $d = \DateTime::createFromFormat($format, $date);
        } else {
            $d = new \DateTime(date($format, strtotime($date)));
        }
        return $d && $d->format($format) == $date;
    }

}
