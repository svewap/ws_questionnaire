<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\AnswerType;

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;

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
class Radiobutton extends Answer
{
    /**
     * shows an Input field after the answer
     *
     * @var boolean
     */
    protected $showTextfield;

    /**
     * Returns the showTextfield
     *
     * @return boolean showTextfield
     */
    public function getShowTextfield()
    {
        return $this->showTextfield;
    }

    /**
     * Sets the showTextfield
     *
     * @param boolean $showTextfield
     * @return void
     */
    public function setShowTextfield($showTextfield)
    {
        $this->showTextfield = $showTextfield;
    }

    /**
     * return the Value shown in the Csv Export
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $rAnswer
     * @param array $options
     * @return string
     */
    public function getCsvValue(\Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer $rAnswer, $options = [])
    {
        if ($rAnswer->getValue() == $this->getUid()) {// || $rAnswer->getCol() == $this->getUid()){
            return $options['marker'];
        } else {
            return '';
        }
    }

    /**
     * return the Value shown in the Csv Export
     * @param array $rAnswer
     * @param array $options
     * @return string
     */
    public function getCsvValueRaw(array $rAnswer, $options = [])
    {
        if ($rAnswer['value'] == $this->getUid()) {// || $rAnswer->getCol() == $this->getUid()){
            return $options['marker'];
        } else {
            return '';
        }
    }

    /**
     * Returns the saveType
     *
     * @return string $saveTxpe
     */
    public function getSaveType()
    {
        return 'replaceAnswer';
    }
}
