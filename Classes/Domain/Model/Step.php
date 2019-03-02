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
class Step extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Type
     *
     * @var string
     */
    protected $type;

    /**
     * Action
     *
     * @var string
     */
    protected $action;

    /**
     * Controller
     *
     * @var string
     */
    protected $controller;

    /**
     * Extension
     *
     * @var string
     */
    protected $extension;


    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'forward':
            case 'redirect':
                $this->type = $type;
                break;
            default:
                $this->type = 'redirect';
        }
    }

    /**
     * Returns the action
     *
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Sets the action
     *
     * @param string $action
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Returns the controller
     *
     * @return string $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Sets the controller
     *
     * @param string $controller
     * @return void
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Returns the extension
     *
     * @return string $extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Sets the extension
     *
     * @param string $extension
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

}
