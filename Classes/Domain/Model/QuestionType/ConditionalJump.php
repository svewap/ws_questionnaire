<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model\QuestionType;

use Kennziffer\KeQuestionnaire\Domain\Model\Question;

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
class ConditionalJump extends Question
{

    /**
     * Dependancies
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Kennziffer\KeQuestionnaire\Domain\Model\Dependency>
     * @lazy
     */
    protected $dependancies;

    /**
     * toPage
     *
     * @var integer
     */
    protected $toPage;

    /**
     * DirectJump
     *
     * @var boolean
     */
    protected $directJump = false;

    /**
     * Javascript
     *
     * @var string
     */
    protected $javascript;

    /**
     * OnlyJs
     *
     * @var boolean
     */
    protected $onlyJs = false;


    /**
     * Returns the directJump
     *
     * @return boolean $directJump
     */
    public function getDirectJump()
    {
        return (boolean)$this->directJump;
    }

    /**
     * Sets the directJump
     *
     * @param boolean $directJump
     * @return void
     */
    public function setDirectJump($directJump)
    {
        $this->directJump = $directJump;
    }

    /**
     * Returns the boolean state of directJump
     *
     * @return boolean
     */
    public function isDirectJump()
    {
        return $this->getDirectJump();
    }

    /**
     * Returns the onlyJs
     *
     * @return boolean $onlyJs
     */
    public function getOnlyJs()
    {
        return (boolean)$this->onlyJs;
    }

    /**
     * Sets the onlyJs
     *
     * @param boolean $onlyJs
     * @return void
     */
    public function setOnlyJs($onlyJs)
    {
        $this->onlyJs = $onlyJs;
    }

    /**
     * Returns the boolean state of onyJs
     *
     * @return boolean
     */
    public function isOnlyJs()
    {
        return $this->getOnlyJs();
    }

    /**
     * Returns the toPage
     *
     * @return integer $toPage
     */
    public function getToPage()
    {
        return $this->toPage;
    }

    /**
     * Sets the toPage
     *
     * @param integer $toPage
     * @return void
     */
    public function setToPage($toPage)
    {
        $this->toPage = $toPage;
    }

    /**
     * Returns the javascript
     *
     * @return string $javascript
     */
    public function getJavascript()
    {
        return $this->javascript;
    }

    /**
     * Sets the javascript
     *
     * @param string $javascript
     * @return void
     */
    public function setJavascript($javascript)
    {
        $this->javascript = $javascript;
    }
}
