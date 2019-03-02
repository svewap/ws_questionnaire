<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


include_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Utility/AddActivatorsToDependency.php';

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);

$pluginSignature = strtolower($extensionName) . '_questionnaire';
$pluginSignature2 = strtolower($extensionName) . '_qlist';
$pluginSignature5 = strtolower($extensionName) . '_view';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tt_content.pi_flexform.wsquestionnaire_questionnaire.list',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_flexforms.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_question',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_question.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_question');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_answer',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_answer.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_answer');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_resultquestion',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_resultquestion.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_resultquestion');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_resultanswer',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_resultanswer.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_resultanswer');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_result',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_result.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_result');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_range',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_range.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_range');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_authcode',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_authcode.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_authcode');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wsquestionnaire_domain_model_dependency',
    'EXT:ws_questionnaire/Resources/Private/Language/locallang_csh_tx_wsquestionnaire_domain_model_dependency.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wsquestionnaire_domain_model_dependency');


/*
 * Backend-Modules
 */
if (TYPO3_MODE === 'BE') {
    $mainModuleName = 'wsQuestionnaireBe';

    //Register Image Area Select Wizard
    // Deprecated since 7.6, needed for 6.2, will be removed with 8
    // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
    //     'wizard_imageAreaSelect',
    //     \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/Wizard/ImageAreaSelectWizard/'
    //  );

    // Hack damit das Modul direkt nach dem Web Modul erscheint
    // die Angabe der $position in addModule() funktioniert hier leider nicht
    if (!isset($TBE_MODULES[$mainModuleName])) {
        $temp_TBE_MODULES = [];
        foreach ($TBE_MODULES as $key => $val) {
            if ($key == 'web') {
                $temp_TBE_MODULES[$key] = $val;
                $temp_TBE_MODULES[$mainModuleName] = '';
            } else {
                $temp_TBE_MODULES[$key] = $val;
            }
        }
        $TBE_MODULES = $temp_TBE_MODULES;
    }

    // Hauptmodul erstellen
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'WapplerSystems.' . $_EXTKEY,
        $mainModuleName,
        '',
        '',
        [],
        [
            'access' => 'user,group',  # Konfiguration
            'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
        ]
    );

    // Authcode Backend Modul der Extension
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'WapplerSystems.' . $_EXTKEY,
        $mainModuleName,
        'Authcode',
        '',
        [
            'Backend' => 'index,authCodes,createAuthCodes,authCodesSimple,authCodesMail,createAndMailAuthCodes,authCodesRemind,remindAndMailAuthCodes',
            'Export' => 'downloadPdf, pdf, downloadAuthCodesCsv'
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_authcode.xml'
        ]
    );

    // Export Backend Modul der Extension
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'WapplerSystems.' . $_EXTKEY,
        $mainModuleName,
        'Export',
        '',
        ['Export' => 'index,csv,csvRb,downloadCsv,downloadCsvRb,pdf,downloadPdf,csvInterval,csvRbInterval,csvCheckInterval,downloadCsvInterval'],
        [
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_export.xml',
        ]
    );

    // Analyse Backend Modul der Extension
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'WapplerSystems.' . $_EXTKEY,
        $mainModuleName,
        'Analyse',
        '',
        ['Analyse' => 'index,questions,general'],
        [
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_analyse.xml',
        ]
    );

    // Report zur Prüfung des FileAcces auf den Temp Ordner
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['WsQuestionnaire'][]
        = \WapplerSystems\WsQuestionnaire\Reports\FileAccessReport::class;

}
