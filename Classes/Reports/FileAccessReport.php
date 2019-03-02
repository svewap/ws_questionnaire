<?php

namespace Kennziffer\KeQuestionnaire\Reports;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Kennziffer.com <info@kennziffer.com>, www.kennziffer.com
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Reports\Status;
use TYPO3\CMS\Reports\StatusProviderInterface;

/**
 *
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FileAccessReport implements StatusProviderInterface
{
    /**
     * @var string
     */
    protected $tmpFileAndPath = '';

    /**
     * @var string
     */

    protected $siteUrl = '';

    /**
     * @var array
     */
    protected $staticStateResponseData = [];

    /**
     * Returns the status of an extension or (sub)system
     *
     * @return array An array of \TYPO3\CMS\Reports\Status objects
     */
    public function getStatus()
    {
        $statusArray = [];
        $failState = '';

        $this->init();
        $failState = $this->checkStatus();

        list($title, $value, $message, $severity) = $this->staticStateResponseData[$failState];

        /** @var Status $status */
        $status = GeneralUtility::makeInstance(ObjectManager::class)->get(
            Status::class,
            $title,
            $value,
            $message,
            $severity
        );

        $statusArray[] = $status;

        return $statusArray;
    }

    /**
     * Do some initialization for texts of the reports
     *
     * @return void
     */
    protected function init()
    {
        $this->tmpFileAndPath = PATH_site . 'typo3temp/ke_questionnaire/pdf/TEST';
        $this->siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

        $this->staticStateResponseData = [
            'ok' => [
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.title'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.ok'),
                '',
                Status::OK
            ],
            'writeFail' => [
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.title'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.warning'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.warning.details'),
                Status::WARNING
            ],
            'tmpFileReadable' => [
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.title'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.error'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.error.explanation'),
                Status::ERROR
            ],
            'unknownErrorCheckingTmpFile' => [
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.title'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.warning'),
                $GLOBALS['LANG']->sL('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang.xml:report.fileAccess.warning.unknown'),
                Status::WARNING
            ]
        ];
    }

    /**
     * checks the status of the temp files
     *
     * @return string
     */
    protected function checkStatus()
    {
        $failState = $this->createAndCheckTmpFile();
        $failState = ($failState === '') ? $this->checkTmpFileReadable() : $failState;

        if (trim($failState) === '') {
            $failState = 'ok';
        }
        return $failState;
    }

    /**
     * Try to write check file to typo3temp folder
     *
     * @return string
     */
    protected function createAndCheckTmpFile()
    {
        if (!is_dir(PATH_site . 'typo3temp/ke_questionnaire/pdf')) {
            @mkdir(PATH_site . 'typo3temp/ke_questionnaire/pdf');
        }
        //create htaccess file
        $htaccess = '
Order Deny,Allow
Deny from all
Allow from 127.0.0.1

<FilesMatch ".*\.(css|js)$">
	Order Allow,Deny
	Allow from all
</FilesMatch>';
        $htaccessFileAndPath = PATH_site . 'typo3temp/ke_questionnaire/.htaccess';
        //$htaccessFileAndPath = PATH_site . 'typo3temp/ke_questionnaire/pdf/.htaccess';
        $writeHtaccess = GeneralUtility::writeFileToTypo3tempDir($htaccessFileAndPath, $htaccess);
        if ($writeHtaccess !== null) {
            return 'writeFail';
        }

        //write test file
        $writeResult = GeneralUtility::writeFileToTypo3tempDir($this->tmpFileAndPath, 'TEST');
        if ($writeResult !== null) {
            return 'writeFail';
        }

        return '';
    }

    /**
     * Try to check if testfile is "world readable"
     *
     * @return string
     */
    protected function checkTmpFileReadable()
    {
        $responseHeaders = [];

        //try to read test file
        $readTestFile = GeneralUtility::getUrl($this->siteUrl . 'typo3temp/ke_questionnaire/pdf/TEST', 1, false,
            $responseHeaders);
        @unlink($this->tmpFileAndPath);

        //if testfile is readable
        if ($responseHeaders['error'] !== 0 && $responseHeaders['error'] !== 22) {
            $this->staticStateResponseData['unknownErrorCheckingTmpFile'][2] .= '<br /><br />' . $responseHeaders['message'];

            return 'unknownErrorCheckingTmpFile';
        }

        if ((int)$responseHeaders['http_code'] === 200) {
            return 'tmpFileReadable';
        }

        return '';
    }
}


