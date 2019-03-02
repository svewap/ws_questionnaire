<?php

namespace Kennziffer\KeQuestionnaire\Utility;

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
class Localization
{

    /**
     * @var string
     */
    protected $locallangPath = 'Resources/Private/Language/';

    /**
     * @var string
     */
    protected $locallangFile = 'locallang.xml';


    /**
     * Returns the locallangPath
     *
     * @return string $locallangPath
     */
    public function getLocallangPath()
    {
        return $this->locallangPath;
    }

    /**
     * Sets the locallangPath
     *
     * @param string $locallangPath
     * @return void
     */
    public function setLocallangPath($locallangPath)
    {
        $this->locallangPath = $locallangPath;
    }

    /**
     * Returns the locallangFile
     *
     * @return string $locallangFile
     */
    public function getLocallangFile()
    {
        return $this->locallangFile;
    }

    /**
     * Sets the locallangFile
     *
     * @param string $locallangFile
     * @return void
     */
    public function setLocallangFile($locallangFile)
    {
        $this->locallangFile = $locallangFile;
    }

    /**
     * translation mapper
     * with this method you can access your own xml file while in original class the locallang file is hardcoded
     *
     * @param string $key The key from the LOCAL_LANG array for which to return the value.
     * @param string $locallangFile
     * @param array $arguments the arguments of the extension, being passed over to vsprintf
     * @return string The localized key
     */
    public function translate($key, $locallangFile = 'locallang.xml', $arguments = null)
    {
        // set locallang file
        if (empty($locallangFile)) {
            $this->setLocallangFile('locallang.xml');
        } else {
            $this->setLocallangFile($locallangFile);
        }

        // build path
        $path = 'LLL:EXT:ke_questionnaire/' . $this->locallangPath . $this->locallangFile;
        $key = $path . ':' . $key;

        // get translation
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, 'keQuestionnaire', $arguments);
    }
}
