<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WapplerSystems.' . $_EXTKEY,
    'Questionnaire',
    [
        'Result' => 'new,create,show,feUserAccess,maxParticipations,authCodeAccess,dependencyAccess,end',
        'Mailing' => 'mail',
        'Evaluation' => 'show',
        'PointRange' => 'showText',
        'Question' => 'list',
        'Ajax' => 'test',
        'Export' => 'downloadPdf',
    ],
    [
        'Result' => 'new,create',
        'Mailing' => '',
        'Evaluation' => '',
        'PointRange' => '',
        'Question' => '',
        'Ajax' => 'test',
        'Export' => 'downloadPdf',
    ]
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WapplerSystems.' . $_EXTKEY,
    'QList',
    [
        'Questionnaire' => 'list',
        'Export' => 'downloadPdf',
    ],
    [
        'Questionnaire' => 'list',
        'Export' => 'downloadPdf',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WapplerSystems.' . $_EXTKEY,
    'View',
    [
        'Result' => 'show',
    ],
    [
        'Result' => 'show',
    ]
);
