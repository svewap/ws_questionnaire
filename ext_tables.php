<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


include_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/Utility/AddActivatorsToDependancy.php';

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);

$pluginSignature = strtolower($extensionName) . '_questionnaire';
$pluginSignature2 = strtolower($extensionName) . '_qlist';
$pluginSignature5 = strtolower($extensionName) . '_view';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tt_content.pi_flexform.kequestionnaire_questionnaire.list', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_flexforms.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_question', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_question.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_question');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_answer', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_answer.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_answer');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_resultquestion', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_resultquestion.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_resultquestion');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_resultanswer', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_resultanswer.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_resultanswer');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_result', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_result.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_result');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_range', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_range.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_range');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_authcode', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_authcode.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_authcode');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kequestionnaire_domain_model_dependancy', 'EXT:ke_questionnaire/Resources/Private/Language/locallang_csh_tx_kequestionnaire_domain_model_dependancy.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kequestionnaire_domain_model_dependancy');


/*
 * Backend-Modules
 */
if (TYPO3_MODE === 'BE'){
   $mainModuleName = 'keQuestionnaireBe';
   
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
        foreach($TBE_MODULES as $key => $val) {
            if($key == 'web') {
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
		'Kennziffer.'.$_EXTKEY,            # Extension-Key
		$mainModuleName,				   # Kategorie
		'',								   # Modulname
		'',                                # Position
		[],     # Controller
		[
            'access' => 'user,group',  # Konfiguration
				'icon'	 => 'EXT:'.$_EXTKEY.'/ext_icon.gif',
				'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod.xml',
        ]
	);
	
    // Authcode Backend Modul der Extension
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Kennziffer.'.$_EXTKEY,                  # Extension-Key
		$mainModuleName,		   # Kategorie
		'Authcode',				   # Modulname
		'',                                # Position
		[
            'Backend' => 'index,authCodes,createAuthCodes,authCodesSimple,authCodesMail,createAndMailAuthCodes,authCodesRemind,remindAndMailAuthCodes',
				'Export'  => 'downloadPdf, pdf, downloadAuthCodesCsv'
        ],     # Controller
		[
            'access' => 'user,group',  # Konfiguration
				'icon'	 => 'EXT:'.$_EXTKEY.'/ext_icon.gif',
				'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod_authcode.xml'
        ]
	);
	
	// Export Backend Modul der Extension
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Kennziffer.'.$_EXTKEY,                  # Extension-Key
		$mainModuleName,		   # Kategorie
		'Export',				   # Modulname
		'',                                # Position
		['Export' => 'index,csv,csvRb,downloadCsv,downloadCsvRb,pdf,downloadPdf,csvInterval,csvRbInterval,csvCheckInterval,downloadCsvInterval'],     # Controller
		[
            'access' => 'user,group',  # Konfiguration
				'icon'	 => 'EXT:'.$_EXTKEY.'/ext_icon.gif',
				'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod_export.xml',
        ]
	);
    
    // Analyse Backend Modul der Extension
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Kennziffer.'.$_EXTKEY,                  # Extension-Key
		$mainModuleName,		   # Kategorie
		'Analyse',				   # Modulname
		'',                                # Position
		['Analyse' => 'index,questions,general'],     # Controller
		[
            'access' => 'user,group',  # Konfiguration
				'icon'	 => 'EXT:'.$_EXTKEY.'/ext_icon.gif',
				'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod_analyse.xml',
        ]
	);  
	
	// Report zur Prüfung des FileAcces auf den Temp Ordner
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['Kennziffer/Questionnaire'][]
		= 'Kennziffer\\KeQuestionnaire\\Reports\\FileAccessReport';
    
}
