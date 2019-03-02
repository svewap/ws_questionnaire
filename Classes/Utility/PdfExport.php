<?php

namespace Kennziffer\KeQuestionnaire\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

require_once ExtensionManagementUtility::extPath('ke_questionnaire') . 'Resources/Private/PHP/Mpdf/mpdf.php';

/**
 *
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PdfExport
{
    /**
     * Create PDF
     *
     * @param string $html
     * @param string $filename
     */
    public function createPdfFromHTML($html, $filename = "ke_questionnaire.pdf")
    {
        $this->createAndCheckTmpFile();

        $pdf = new \mPDF();
        $pdf->WriteHtml($html);
        $pdf->Output($filename, 'D');
        //$pdf->Output();
        exit;
    }

    /**
     * Try to write check file to typo3temp folder
     */
    protected function createAndCheckTmpFile()
    {
        $this->tmpFileAndPath = PATH_site . 'typo3temp/ke_questionnaire/pdf/TEST';
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
        GeneralUtility::writeFileToTypo3tempDir($htaccessFileAndPath, $htaccess);
        $htaccessFileAndPath = PATH_site . 'typo3temp/ke_questionnaire/pdf/.htaccess';
        GeneralUtility::writeFileToTypo3tempDir($htaccessFileAndPath, $htaccess);
    }
}

