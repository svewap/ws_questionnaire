<?php

namespace Kennziffer\KeQuestionnaire\Utility;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
class BackendTsfe
{

    /**
     * @var int
     */
    public $pid = 1;


    function buildTSFE()
    {
        // j.v. page ID and TypeNum  needed to make the instance of TypoScriptFrontendController
        $typeNum = 0;
        if ($this->pid < 1) {
            $this->pid = 1;
        }
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\TimeTracker;
            $GLOBALS['TT']->start();
        }
        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $TSFEclassName */
        $TSFEclassName = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TypoScriptFrontendController::class, null,
            $this->pid, $typeNum, 1, '', '', '', '');
        $GLOBALS['TSFE'] = new $TSFEclassName($GLOBALS['TYPO3_CONF_VARS'], $this->pid, $typeNum, 1, '', '', '', '');
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->fetch_the_id();
        $GLOBALS['TSFE']->getPageAndRootline();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->tmpl->getFileName_backPath = PATH_site;
        $GLOBALS['TSFE']->forceTemplateParsing = 1;
        $GLOBALS['TSFE']->getConfigArray();
    }
}
