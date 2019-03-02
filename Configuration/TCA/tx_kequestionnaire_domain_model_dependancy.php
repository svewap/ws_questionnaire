<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_dependancy',
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'fe_cruser_id' => 'fe_cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'answer,',
        'iconfile' => 'EXT:ke_questionnaire/Resources/Public/Icons/dependancy.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, answer',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, relation, answer,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_kequestionnaire_domain_model_authcode',
                'foreign_table_where' => 'AND tx_kequestionnaire_domain_model_authcode.pid=###CURRENT_PID### AND tx_kequestionnaire_domain_model_authcode.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true ,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true ,
                ],
            ],
        ],
        'answer' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_dependancy.answer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'Kennziffer\\KeQuestionnaire\\Utility\\AddActivatorsToDependancy->addItems',
                'items' => [],
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
            ],
        ],
        'dquestion' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'relation' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_dependancy.relation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_dependancy.relation.none', 'none'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_dependancy.relation.and', 'and'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_dependancy.relation.or', 'or']
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => 'none',
            ],
        ],
    ],

];