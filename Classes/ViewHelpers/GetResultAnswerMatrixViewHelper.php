<?php

namespace Kennziffer\KeQuestionnaire\ViewHelpers;

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
 * get the result answer for the matrix
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class GetResultAnswerMatrixViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{


    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;


    /**
     * Returns a requested question from result record
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result
     * @param integer $questionUid
     * @param integer $rowUid
     * @param integer $columnUid
     * @param string $matrixType
     * @param boolean $radio
     * @param integer $clone
     * @return
     */
    public function render(
        $result,
        $questionUid,
        $rowUid,
        $columnUid,
        $matrixType = 'normal',
        $radio = false,
        $clone = 0
    ) {
        if (!$radio) {
            $rAnswer = $result->getAnswer($questionUid, $rowUid, $columnUid);
            if ($rAnswer) {
                return $rAnswer;
            }
        } else {
            $rAnswer = $result->getRadioAnswer($questionUid, $rowUid, $columnUid);
            return $rAnswer;
        }
        return null;
    }
}
