<?php

namespace Kennziffer\KeQuestionnaire\Ajax;

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
 * Abstract Class to process Ajax Actions in Questionnaires
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
abstract class AbstractAjax implements AjaxInterface
{

    /**
     * return value as JSON
     *
     * @param mixed $value Value to convert
     * @return string JSON converted value
     */
    public function convertValueToJson($value): string
    {
        return json_encode($value);
    }

    /**
     * convertAjaxFormArray
     *
     * @param array $values
     * @return array $values
     */
    public function convertAjaxFormArray($values): array
    {
        if ($values['formData']) {
            parse_str($values['formData'], $formData);
            $values['formData'] = $formData;
        }
        return $values;
    }

}
