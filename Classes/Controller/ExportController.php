<?php

namespace Kennziffer\KeQuestionnaire\Controller;

use Kennziffer\KeQuestionnaire\Domain\Model\Result;

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
 * Backend Controller
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ExportController extends BackendController
{

    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\CsvExport
     */
    protected $csvExport;

    /**
     * inject csvExport
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\CsvExport $csvExport
     */
    public function injectCsvExport(\Kennziffer\KeQuestionnaire\Utility\CsvExport $csvExport)
    {
        $this->csvExport = $csvExport;
    }

    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\PdfExport
     */
    protected $pdfExport;

    /**
     * inject pdfExport
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\PdfExport $pdfExport
     */
    public function injectPdfExport(\Kennziffer\KeQuestionnaire\Utility\PdfExport $pdfExport)
    {
        $this->pdfExport = $pdfExport;
    }

    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\BackendTsfe
     */
    protected $backendTsfe;

    /**
     * inject backendTsfe
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\BackendTsfe $backendTsfe
     */
    public function injectBackendTsfe(\Kennziffer\KeQuestionnaire\Utility\BackendTsfe $backendTsfe)
    {
        $this->backendTsfe = $backendTsfe;
    }

    /**
     * action index
     */
    public function indexAction()
    {
        $this->view->assign('questionnaires', $this->questionnaireRepository->findAll());
    }

    /**
     * CSV Action
     * display for csv export
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @ignorevalidaton $plugin
     */
    public function csvAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }
        //count all the participations for display in header
        $counter = $this->countParticipations();
        //check if there is an interval
        $interval = $this->extConf->getCsvExportInterval();
        //$interval = 1;
        if ($interval && $counter['all'] > $interval) {
            session_start();
            $_SESSION['progval'] = 0;
            $_SESSION['fileName'] = 'csv_temp_' . time();
            session_write_close();
        }
        $this->view->assign('csvExportInterval', $interval);
        $this->view->assign('counter', $counter);
        $this->view->assign('plugin', $this->plugin);
    }

    /**
     * CSV Interval Action
     * @param int $pluginUid
     * @param int $interval
     * @return false|string
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function csvIntervalAction($pluginUid, $interval)
    {
        //standard path for interval-file
        $pathName = 'typo3temp/ke_questionnaire';
        //initialize the export data
        $this->iniCsvExport();
        //get the questionnaire-data from tt_content element
        $this->questionnaire = $this->questionnaireRepository->findByUid($this->plugin['uid']);
        //check if only finished participations should be exported and get the results
        if ($this->request->getArgument('finished') == 'finished') {
            $resultCount = $this->questionnaire->countResults(true);
        } else {
            $resultCount = $this->questionnaire->countResults(false);
        }
        $counter = 0;
        //create the interval
        while ($counter <= $resultCount) {
            /* Increase counter stored in session variable */
            session_start();
            $csvTempFile = $_SESSION['fileName'];
            $interval = $this->request->getArgument('interval');
            $fileName = $pathName . '/' . $csvTempFile;
            //when the progval is 0 => create datafile
            if ($_SESSION['progval'] == 0) {
                if (!file_exists(PATH_site . $pathName)) {
                    mkdir(PATH_site . $pathName, 0777);
                    chmod(PATH_site . $pathName, 0777);
                }
            } else {
                //else open file and add data
                //get old file content
                $oldContent = '';
                if (file_exists(PATH_site . $fileName)) {
                    $oldContent = file_get_contents(PATH_site . $fileName);
                }
            }
            //Load the interval batch
            $correct_interval = $interval;
            if (($correct_interval + $counter) > $resultCount) {
                $correct_interval = $resultCount - $_SESSION['progval'];
            }
            if ($this->request->getArgument('finished') == 'finished') {
                $this->csvExport->setResults($this->resultRepository->findFinishedForPidInterval($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
                $this->csvExport->setResultsRaw($this->resultRepository->findFinishedForPidIntervalRaw($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
            } else {
                $this->csvExport->setResults($this->resultRepository->findAllForPidInterval($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
                $this->csvExport->setResultsRaw($this->resultRepository->findAllForPidIntervalRaw($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
            }
            $csvContent = $this->csvExport->processQbIntervalExport($this->plugin, $oldContent);
            //clear the file
            $csvFile = fopen(PATH_site . $fileName, 'w+b');
            //write the js
            fwrite($csvFile, $csvContent);
            fclose($csvFile);
            chmod(PATH_site . $fileName, 0777);

            if ($correct_interval != $interval) {
                $_SESSION['progval'] = $resultCount;
                $counter = $resultCount + 1;
            } else {
                $_SESSION['progval'] = $counter;
                $counter += $correct_interval;
            }
            session_write_close();
            sleep(1);
        }
        /* Reset the counter in session variable to 0 */
        session_start();

        //delete file when everything is done and send the data back
        $finishedFileName = $pathName . '/csv_finished_' . time();
        //get old file content
        $oldContent = '';
        if (file_exists(PATH_site . $fileName)) {
            $oldContent = file_get_contents(PATH_site . $fileName);
            //load all results for uids


            if ($this->request->getArgument('finished') == 'finished') {
                $this->csvExport->setResults($this->resultRepository->findFinishedForPid($this->storagePid));
            } else {
                $this->csvExport->setResults($this->resultRepository->findAllForPid($this->storagePid));
            }


            //create first rows and first cols and fill in the content
            $csvContent = $this->csvExport->finishIntervalExport($this->plugin, $csvContent);
            //write this content
            //clear the file
            $finishedCsvFile = fopen(PATH_site . $finishedFileName, 'w+b');
            //write the js
            fwrite($finishedCsvFile, $csvContent);
            fclose($finishedCsvFile);
            chmod(PATH_site . $finishedFileName, 0777);
            //delete the temp file
            if (file_exists(PATH_site . $fileName)) {
                unlink(PATH_site . $fileName);
            }
        }
        $_SESSION['progval'] = 0;

        session_write_close();
        return json_encode($finishedFileName);
    }

    /**
     * CSV Download Interval Action
     * @param string $fileName
     */
    public function downloadCsvIntervalAction($fileName)
    {
        $csvdata = file_get_contents(PATH_site . $fileName);
        unlink(PATH_site . $fileName);
        $encoding = "utf-8";
        if ($encoding != mb_detect_encoding($csvdata)) {
            $csvdata = mb_convert_encoding($csvdata, $encoding, mb_detect_encoding($csvdata));
        }

        if (strtolower($encoding) == "utf-8") {
            $csvdata = pack("CCC", 0xef, 0xbb, 0xbf) . $csvdata;
            header("content-type: application/csv-tab-delimited-table; Charset=utf-8");
        } else {
            header("content-type: application/csv-tab-delimited-table;");
        }

        header("content-length: " . strlen($csvdata));
        header("content-disposition: attachment; filename=\"csv_export.csv\"");

        print $csvdata;
        exit;
    }

    /**
     * CSV Check Interval Action
     * @param int $pluginUid
     * @param int $interval
     * @return false|string
     */
    public function csvCheckIntervalAction($pluginUid, $interval)
    {
        session_start();
        if (!isset($_SESSION['progval']) || $_SESSION['progval'] == 0) {
            $_SESSION['progval'] = 0;
        }
        session_write_close();
        return json_encode($_SESSION['progval']);
    }

    /**
     * CSV Result Based Action
     * display for csv export
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @ignorevalidaton $plugin
     */
    public function csvRbAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }
        //count all the participations for display in header
        $counter = $this->countParticipations();
        //check if there is an interval
        $interval = $this->extConf->getCsvExportInterval();
        //$interval = 1;
        if ($interval && $counter['all'] > $interval) {
            session_start();
            $_SESSION['progval'] = 0;
            $_SESSION['fileName'] = 'csv_temp_' . time();
            session_write_close();
        }
        $this->view->assign('csvExportInterval', $interval);
        $this->view->assign('counter', $counter);
        $this->view->assign('plugin', $this->plugin);
    }

    /**
     * CSV Interval Action
     * @param int $pluginUid
     * @param int $interval
     * @return false|string
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function csvRbIntervalAction($pluginUid, $interval)
    {
        //standard path for interval-file
        $pathName = 'typo3temp/ke_questionnaire';
        //initialize the export data
        $this->iniCsvExport();
        //get the questionnaire-data from tt_content element
        $this->questionnaire = $this->questionnaireRepository->findByUid($this->plugin['uid']);
        //check if only finished participations should be exported and get the results
        if ($this->request->getArgument('finished') == 'finished') {
            $resultCount = $this->questionnaire->countResults(true);
        } else {
            $resultCount = $this->questionnaire->countResults(false);
        }
        $counter = 0;
        //create the interval
        while ($counter <= $resultCount) {
            /* Increase counter stored in session variable */
            session_start();
            $csvTempFile = $_SESSION['fileName'];
            $interval = $this->request->getArgument('interval');
            $fileName = $pathName . '/' . $csvTempFile;
            //when the progval is 0 => create datafile
            if ($_SESSION['progval'] == 0) {
                if (!file_exists(PATH_site . $pathName)) {
                    mkdir(PATH_site . $pathName, 0777);
                    chmod(PATH_site . $pathName, 0777);
                }
            } else {
                //else open file and add data
                //get old file content
                $oldContent = '';
                if (file_exists(PATH_site . $fileName)) {
                    $oldContent = file_get_contents(PATH_site . $fileName);
                }
            }
            //Load the interval batch
            $correct_interval = $interval;
            if (($correct_interval + $counter) > $resultCount) {
                $correct_interval = $resultCount - $_SESSION['progval'];
            }
            if ($this->request->getArgument('finished') == 'finished') {
                $this->csvExport->setResults($this->resultRepository->findFinishedForPidInterval($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
                $this->csvExport->setResultsRaw($this->resultRepository->findFinishedForPidIntervalRaw($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
            } else {
                $this->csvExport->setResults($this->resultRepository->findAllForPidInterval($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
                $this->csvExport->setResultsRaw($this->resultRepository->findAllForPidIntervalRaw($this->storagePid,
                    $correct_interval, $_SESSION['progval']));
            }
            $csvContent = $this->csvExport->processRbIntervalExport($this->plugin, $oldContent);
            //clear the file
            $csvFile = fopen(PATH_site . $fileName, 'w+b');
            //write the js
            fwrite($csvFile, $csvContent);
            fclose($csvFile);
            chmod(PATH_site . $fileName, 0777);

            if ($correct_interval != $interval) {
                $_SESSION['progval'] = $resultCount;
                $counter = $resultCount + 1;
            } else {
                $_SESSION['progval'] = $counter;
                $counter += $correct_interval;
            }
            session_write_close();
            sleep(1);
        }
        /* Reset the counter in session variable to 0 */
        session_start();

        //delete file when everything is done and send the data back
        $finishedFileName = $pathName . '/csv_finished_' . time();
        //get old file content
        $oldContent = '';
        if (file_exists(PATH_site . $fileName)) {
            $oldContent = file_get_contents(PATH_site . $fileName);
            //load all results for uids
            if ($this->request->getArgument('finished') == 'finished') {
                $this->csvExport->setResults($this->resultRepository->findFinishedForPid($this->storagePid));
            } else {
                $this->csvExport->setResults($this->resultRepository->findAllForPid($this->storagePid));
            }
            //create first rows and first cols and fill in the content
            $csvContent = $this->csvExport->finishRbIntervalExport($this->plugin, $csvContent);
            //write this content
            //clear the file
            $finishedCsvFile = fopen(PATH_site . $finishedFileName, 'w+b');
            //write the js
            fwrite($finishedCsvFile, $csvContent);
            fclose($finishedCsvFile);
            chmod(PATH_site . $finishedFileName, 0777);
            //delete the temp file
            if (file_exists(PATH_site . $fileName)) {
                unlink(PATH_site . $fileName);
            }
        }
        $_SESSION['progval'] = 0;

        session_write_close();
        return json_encode($finishedFileName);
    }


    /**
     * PDF Action
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @ignorevalidaton $plugin
     */
    public function pdfAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }

        $this->view->assign('results', $this->resultRepository->findAllForPid($this->storagePid));
        $this->view->assign('counter', $this->countParticipations());
        $this->view->assign('plugin', $this->plugin);
    }

    /**
     * Download CSV Action
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @ignorevalidaton $plugin
     */
    public function downloadCsvAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }

        $this->iniCsvExport();
        //load the results
        if ($this->request->getArgument('finished') == 'finished') {
            $this->csvExport->setResultsRaw($this->resultRepository->findFinishedForPidRaw($this->storagePid));
            $this->csvExport->setResults($this->resultRepository->findFinishedForPid($this->storagePid));
        } else {
            $this->csvExport->setResultsRaw($this->resultRepository->findAllForPidRaw($this->storagePid));
            $this->csvExport->setResults($this->resultRepository->findAllForPid($this->storagePid));
        }
        //create the csvdata
        $csvdata .= $this->csvExport->createQuestionBased($this->plugin);

        if ($encoding != mb_detect_encoding($csvdata)) {
            $csvdata = mb_convert_encoding($csvdata, $encoding, mb_detect_encoding($csvdata));
        }
        if (strtolower($encoding) == "utf-8") {
            $csvdata = pack("CCC", 0xef, 0xbb, 0xbf) . $csvdata;
            header("content-type: application/csv-tab-delimited-table; Charset=utf-8");
        } else {
            header("content-type: application/csv-tab-delimited-table;");
        }

        header("content-length: " . strlen($csvdata));
        header("content-disposition: attachment; filename=\"csv_export.csv\"");

        print $csvdata;
        exit;
    }

    /**
     * Download CSV Result Based Action
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @ignorevalidaton $plugin
     */
    public function downloadCsvRbAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }

        $this->iniCsvExport();
        //load the results
        if ($this->request->getArgument('finished') == 'finished') {
            $this->csvExport->setResultsRaw($this->resultRepository->findFinishedForPidRaw($this->storagePid));
            $this->csvExport->setResults($this->resultRepository->findFinishedForPid($this->storagePid));
        } else {
            $this->csvExport->setResultsRaw($this->resultRepository->findAllForPidRaw($this->storagePid));
            $this->csvExport->setResults($this->resultRepository->findAllForPid($this->storagePid));
        }
        //create the csvdata
        $csvdata .= $this->csvExport->createResultBased($this->plugin);

        if ($encoding != mb_detect_encoding($csvdata)) {
            $csvdata = mb_convert_encoding($csvdata, $encoding, mb_detect_encoding($csvdata));
        }
        if (strtolower($encoding) == "utf-8") {
            $csvdata = pack("CCC", 0xef, 0xbb, 0xbf) . $csvdata;
            header("content-type: application/csv-tab-delimited-table; Charset=utf-8");
        } else {
            header("content-type: application/csv-tab-delimited-table;");
        }
        header("content-length: " . strlen($csvdata));
        header("content-disposition: attachment; filename=\"csv_export.csv\"");

        print $csvdata;
        exit;
    }

    /**
     * Download CSV Action
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @ignorevalidaton $plugin
     */
    public function downloadAuthCodesCsvAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }

        //load the AuthCodes
        $authCodes = $this->authCodeRepository->findAllForPid($this->storagePid)->toArray();
        //create the csvdata
        $this->csvExport->extConf = $this->extConf;
        $csvdata .= $this->csvExport->createAuthCodes($authCodes);

        if ($encoding != mb_detect_encoding($csvdata)) {
            $csvdata = mb_convert_encoding($csvdata, $encoding, mb_detect_encoding($csvdata));
        }
        if (strtolower($encoding) == "utf-8") {
            $csvdata = pack("CCC", 0xef, 0xbb, 0xbf) . $csvdata;
            header("content-type: application/csv-tab-delimited-table; Charset=utf-8");
        } else {
            header("content-type: application/csv-tab-delimited-table;");
        }

        header("content-length: " . strlen($csvdata));
        header("content-disposition: attachment; filename=\"csv_export.csv\"");

        print $csvdata;
        exit;
    }

    /**
     * Initialize the CSV Object
     */
    private function iniCsvExport()
    {
        $csvdata = '';

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('ke_questionnaire_premium')) {
            $this->csvExport = $this->objectManager->get('Kennziffer\KeQuestionnairePremium\Utility\CsvExport');

            if ($this->request->hasArgument('averagePoints')) {
                $this->csvExport->setAveragePoints($this->request->getArgument('averagePoints'));
            } else {
                $this->csvExport->setAveragePoints($this->plugin->ffdata['settings']['csv']['averagePoints']);
            }
            if ($this->request->hasArgument('averagePointsAll')) {
                $this->csvExport->setAveragePointsAll($this->request->getArgument('averagePointsAll'));
            } else {
                $this->csvExport->setAveragePointsAll($this->plugin->ffdata['settings']['csv']['averagePointsAll']);
            }
            if ($this->request->hasArgument('additionalParameter')) {
                $this->csvExport->setAdditionalParameter($this->request->getArgument('additionalParameter'));
            } else {
                $this->csvExport->setAdditionalParameter($this->plugin->ffdata['settings']['csv']['additionalParameter']);
            }
        }
        if ($this->request->hasArgument('separator')) {
            $this->csvExport->setSeparator($this->request->getArgument('separator'));
        } else {
            $this->csvExport->setSeparator($this->plugin->ffdata['settings']['csv']['separator']);
        }
        if ($this->request->hasArgument('text')) {
            $this->csvExport->setText($this->request->getArgument('text'));
        } else {
            $this->csvExport->setText($this->plugin->ffdata['settings']['csv']['text']);
        }
        if ($this->request->hasArgument('singleMarker')) {
            $this->csvExport->setSingleMarker($this->request->getArgument('singleMarker'));
        } else {
            $this->csvExport->setSingleMarker($this->plugin->ffdata['settings']['csv']['singleMarker']);
        }
        if ($this->request->hasArgument('showQText')) {
            $this->csvExport->setShowQText($this->request->getArgument('showQText'));
        } else {
            $this->csvExport->setShowQText($this->plugin->ffdata['settings']['csv']['showQText']);
        }
        if ($this->request->hasArgument('showAText')) {
            $this->csvExport->setShowAText($this->request->getArgument('showAText'));
        } else {
            $this->csvExport->setShowAText($this->plugin->ffdata['settings']['csv']['showAText']);
        }
        if ($this->request->hasArgument('encoding')) {
            $encoding = $this->request->getArgument('encoding');
        } else {
            $encoding = $this->plugin->ffdata['settings']['csv']['encoding'];
        }
        if ($this->request->hasArgument('totalPoints')) {
            $this->csvExport->setTotalPoints($this->request->getArgument('totalPoints'));
        } else {
            $this->csvExport->setTotalPoints($this->plugin->ffdata['settings']['csv']['totalPoints']);
        }
        if ($this->request->hasArgument('questionPoints')) {
            $this->csvExport->setQuestionPoints($this->request->getArgument('questionPoints'));
        } else {
            $this->csvExport->setQuestionPoints($this->plugin->ffdata['settings']['csv']['questionPoints']);
        }
    }

    /**
     * Download PDF Action
     *
     * @param bool $storage
     * @param bool $plugin
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @ignorevalidaton $plugin
     */
    public function downloadPdfAction($storage = false, $plugin = false)
    {
        if ($storage) {
            $this->storagePid = $storage;
        }
        if ($plugin) {
            $this->plugin = $plugin;
        }
        //check the pdf type
        if ($this->request->hasArgument('pdfType')) {
            $pdfType = $this->request->getArgument('pdfType');
        } else {
            $pdfType = 'empty';
        }

        switch ($pdfType) {
            //only questions
            case 'empty':
                $this->createPdf();
                break;
            //filled with a participation
            case 'filled':
                $this->createPdf($this->request->getArgument('selectedResult'));
                break;
            //compared to the given correct answers
            case 'compared':
                $this->createPdf($this->request->getArgument('selectedResult'), true);
                break;
            default:
                $this->forward('pdf');
                break;
        }
        //exit;
    }

    /**
     * Create Empty Pdf
     *
     * @param integer $resultId
     * @param boolean $compared
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function createPdf($resultId = null, $compared = false)
    {
        $requestedPage = 0;

        if ($this->request->hasArgument('questionnaire')) {
            $this->plugin = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('tt_content',
                $this->request->getArgument('questionnaire'));
        }

        //the tsfe data is needed
        $this->backendTsfe->buildTSFE();
        //load the questionnaire
        $this->questionnaire = $this->questionnaireRepository->findByUid($this->plugin['uid']);
        $this->view->assign('questionnaire', $this->questionnaire);

        //load the result if there is a resuldId given
        if ($resultId) {
            $result = $this->resultRepository->findByUid($resultId);
        } else {
            $result = $this->objectManager->get(Result::class);
        }
        $this->view->assign('result', $result);

        //if there should be a comparision load the compare-Result
        if ($compared) {
            $this->view->assign('compare', $this->questionnaire->getCompareResult());
        }

        //load the css-data for the pdf
        $css_filename = PATH_site . 'typo3conf/ext/' . $this->request->getControllerExtensionKey() . '/Resources/Public/Css/KeQuestionnaire.css';
        $css_filename2 = PATH_site . 'typo3conf/ext/' . $this->request->getControllerExtensionKey() . '/Resources/Public/Css/PDF.css';
        $css = '<style>' . file_get_contents($css_filename) . "\n" . file_get_contents($css_filename2) . '</style>';
        //render the pdf-html-data
        $content = $this->view->render();
        //remove the js-scripts
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);

        //replace image urls in Backend, Frontend may need other code
        $base = str_replace("/typo3", '', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        $base = str_replace("/mod.php", '', $base);
        $content = str_replace('<img src="fileadmin/', '<img src="http://' . $base . '/fileadmin/', $content);
        //create the pdf
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($content, 'pdf');
        $this->pdfExport->createPdfFromHTML($css . '<br>' . $content);
    }

    /**
     * get the Questions for the questionnaire
     *
     * @param array $plugin
     * @ignorevalidaton $plugin
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    private function getQuestions($plugin)
    {
        $pids = explode(',', $plugin['pages']);
        $storagePid = $pids[0];

        $questions = $this->questionRepository->findAllForPid($storagePid);

        return $questions;
    }
}
