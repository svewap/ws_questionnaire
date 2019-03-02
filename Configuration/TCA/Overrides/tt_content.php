<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$_EXTKEY = 'ws_questionnaire';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'WapplerSystems.'.$_EXTKEY,
    'Questionnaire',
    'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_be.xlf:default_title'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'WapplerSystems.'.$_EXTKEY,
    'QList',
    'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_be.xlf:list_title'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'WapplerSystems.'.$_EXTKEY,
    'View',
    'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_be.xlf:view_title'
);

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_questionnaire';
$pluginSignature2 = strtolower($extensionName) . '_qlist';
$pluginSignature5 = strtolower($extensionName) . '_view';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature2] = 'layout,select_key,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature2] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature5] = 'layout,select_key,recursive';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/questionnaire.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature2, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/qlist.xml');
