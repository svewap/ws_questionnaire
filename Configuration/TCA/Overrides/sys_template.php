<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$_EXTKEY = 'ws_questionnaire';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Questionnaire');