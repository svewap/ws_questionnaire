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
class ClozeTerm extends Answer
{
    /**
     * ClozePosition
     *
     * @var integer
     */
    protected $clozePosition;

    /**
     * Returns the clozePosition
     *
     * @return integer $clozePosition
     */
    public function getClozePosition()
    {
        return $this->clozePosition;
    }


    /**
     * Sets the clozePosition
     *
     * @param integer $clozePosition
     * @return void
     */
    public function setClozePosition($clozePosition)
    {
        $this->clozePosition = $clozePosition;
    }

    /**
     *
     * @param string $text The text to search in
     * @return array Array containing the position informations for one specified answer position
     */
    public function getWordPosition($text)
    {
        if (!$this->getClozePosition()) {
            $wordPosition = 1;
        } else {
            $wordPosition = $this->getClozePosition();
        }

        $positions = [];

        mb_ereg_search_init($text, "\b" . $this->getTitle() . "\b");
        while ($position = mb_ereg_search_pos()) {
            $positions[] = $position;
        }

        return $positions[$wordPosition - 1];
    }
}
