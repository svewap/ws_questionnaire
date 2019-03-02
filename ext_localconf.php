<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Kennziffer.' . $_EXTKEY,
    'Questionnaire',
    [
        'Result' => 'new,create,show,feUserAccess,maxParticipations,authCodeAccess,dependancyAccess,end',
        'Mailing' => 'mail',
        'Evaluation' => 'show',
        'PointRange' => 'showText',
        'Question' => 'list',
        'Ajax' => 'test',
        'Export' => 'downloadPdf',
    ],
    // non-cacheable actions
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
    'Kennziffer.' . $_EXTKEY,
    'QList',
    [
        'Questionnaire' => 'list',
        'Export' => 'downloadPdf',
    ],
    // non-cacheable actions
    [
        'Questionnaire' => 'list',
        'Export' => 'downloadPdf',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Kennziffer.' . $_EXTKEY,
    'View',
    [
        'Result' => 'show',
    ],
    // non-cacheable actions
    [
        'Result' => 'show',
    ]
);
