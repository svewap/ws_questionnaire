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
class ExtConf implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Enable FeUser Marker
     *
     * @var boolean
     */
    protected $enableFeUserMarker;

    /**
     * EmailAddress
     *
     * @var string
     */
    protected $emailAddress;

    /**
     * EmailSender
     *
     * @var string
     */
    protected $emailSender;

    /**
     * EmailSubject
     *
     * @var string
     */
    protected $emailSubject;

    /**
     * CsvExportInterval
     *
     * @var integer
     */
    protected $csvExportInterval;


    /**
     * Premium
     *
     * @var array
     */
    public $premium;


    /**
     * @var boolean
     */
    public $enableAuthCode2feUser;


    /**
     * @var boolean
     */
    public $enableAuthCode2feGroups;

    /**
     * @var boolean
     */
    public $enableAuthCode2ttAddress;


    /**
     * Constructor of this class
     */
    public function __construct()
    {
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ke_questionnaire']);
        if (is_array($extConf)) {
            foreach ($extConf as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                }
            }
        } else {
            throw new \Kennziffer\KeQuestionnaire\Exception('saveExtConf', 1349685793);
        }
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('ke_questionnaire_premium')) {
            $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ke_questionnaire_premium']);
            if (is_array($extConf)) {
                $this->premium = $extConf;
            }
        }
    }

    /**
     * Returns the emailAddress
     *
     * @return string $emailAddress
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Sets the emailAddress
     *
     * @param string $emailAddress
     * @return void
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Returns the enableFeUserMarker
     *
     * @return boolean $enableFeUserMarker
     */
    public function getEnableFeUserMarker()
    {
        return $this->enableFeUserMarker;
    }

    /**
     * Sets the enableFeUserMarker
     *
     * @param string $enableFeUserMarker
     * @return void
     */
    public function setEnableFeUserMarker($enableFeUserMarker)
    {
        $this->enableFeUserMarker = $enableFeUserMarker;
    }

    /**
     * Returns the emailSender
     *
     * @return string $emailSender
     */
    public function getEmailSender()
    {
        return $this->emailSender;
    }

    /**
     * Sets the emailSender
     *
     * @param string $emailSender
     * @return void
     */
    public function setEmailSender($emailSender)
    {
        $this->emailSender = $emailSender;
    }

    /**
     * Returns the emailSubject
     *
     * @return string $emailSubject
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * Sets the emailSubject
     *
     * @param string $emailSubject
     * @return void
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;
    }

    /**
     * Returns the csvExportInterval
     *
     * @return string $csvExportInterval
     */
    public function getCsvExportInterval()
    {
        return $this->csvExportInterval;
    }

    /**
     * Sets the csvExportInterval
     *
     * @param string $csvExportInterval
     * @return void
     */
    public function setCsvExportInterval($csvExportInterval)
    {
        $this->csvExportInterval = $csvExportInterval;
    }

    /**
     * @return bool
     */
    public function isEnableAuthCode2feUser()
    {
        return $this->enableAuthCode2feUser;
    }

    /**
     * @param bool $enableAuthCode2feUser
     */
    public function setEnableAuthCode2feUser($enableAuthCode2feUser)
    {
        $this->enableAuthCode2feUser = $enableAuthCode2feUser;
    }

    /**
     * @return bool
     */
    public function isEnableAuthCode2feGroups()
    {
        return $this->enableAuthCode2feGroups;
    }

    /**
     * @param bool $enableAuthCode2feGroups
     */
    public function setEnableAuthCode2feGroups($enableAuthCode2feGroups)
    {
        $this->enableAuthCode2feGroups = $enableAuthCode2feGroups;
    }

    /**
     * @return bool
     */
    public function isEnableAuthCode2ttAddress()
    {
        return $this->enableAuthCode2ttAddress;
    }

    /**
     * @param bool $enableAuthCode2ttAddress
     */
    public function setEnableAuthCode2ttAddress($enableAuthCode2ttAddress)
    {
        $this->enableAuthCode2ttAddress = $enableAuthCode2ttAddress;
    }


}