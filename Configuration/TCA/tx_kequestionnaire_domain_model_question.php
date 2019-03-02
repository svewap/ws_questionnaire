<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
        'type' => 'type',
        'thumbnail' => 'image',
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
        'searchFields' => 'title,show_title,text,help_text,image,image_position,is_mandatory,must_be_correct,answers,',
        'iconfile' => 'EXT:ke_questionnaire/Resources/Public/Icons/question.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, show_title, text, help_text, image, image_position, is_mandatory, must_be_correct, answers, dependancies, to_page, direct_jump, javascript, only_js',
    ],
    'types' => [
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, show_title, text;;4;richtext[], image;;3, is_mandatory;;2,template,--div--;LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.answers,answers,random_answers,column_count,max_answers,min_answers,--div--;LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.dependancies,dependancies,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\PageBreak' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Html' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Text' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Typo3Content' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, content_id'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\TypoScript' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\TypoScriptPath' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Group' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\ConditionalJump' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, dependancies, to_page, direct_jump, javascript, only_js,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\PlausiCheck' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, dependancies,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
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
                'foreign_table' => 'tx_kequestionnaire_domain_model_question',
                'foreign_table_where' => 'AND tx_kequestionnaire_domain_model_question.pid=###CURRENT_PID### AND tx_kequestionnaire_domain_model_question.sys_language_uid IN (-1,0)',
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
        'type' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.Question', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.PageBreak', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\PageBreak'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.ConditionalJump', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\ConditionalJump'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.PlausiCheck', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\PlausiCheck'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.Group', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Group'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.Html', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Html'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.Text', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Text'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.Typo3Content', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Typo3Content'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.TypoScript', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\TypoScript'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.TypoScriptPath', 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\TypoScriptPath'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => 'Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question',
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'wizards' => [
                    'title_picker' => [
                        'type' => 'select',
                        'mode' => '',
                        'items' => [
                            ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.type.I.2', 'Pagebreak'],
                        ],
                    ],
                ],
            ],
        ],
        'show_title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.show_title',
            'config' => [
                'type' => 'check',
            ],
        ],
        'text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.text',
            'config' => [
                'type' => 'text',
                'cols' => 80,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => [
                    't3editorHtml' => [
                        'enableByTypeConfig' => 1,
                        'type' => 'userFunc',
                        'userFunc' => 'TYPO3\\CMS\\T3Editor\\FormWizard->main',
                        'params' => [
                            'format' => 'html',
                        ],
                    ],
                    't3editorTypoScript' => [
                        'enableByTypeConfig' => 1,
                        'type' => 'userFunc',
                        'userFunc' => 'TYPO3\\CMS\\T3Editor\\FormWizard->main',
                        'params' => [
                            'format' => 'ts',
                        ],
                    ],
                ],
            ],
        ],
        'help_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.help_text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
        'image' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.image',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_kequestionnaire',
                'show_thumbs' => 1,
                'size' => 5,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
            ],
        ],
        'image_position' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.image_position',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.image_position.I.1', 'top'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.image_position.I.2', 'right'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.image_position.I.3', 'left'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.image_position.I.4', 'bottom']
                ],
                'size' => 1,
                'maxitems' => 1,
                'default' => 'top',
                'renderType' => 'selectSingle',
            ],
        ],
        'is_mandatory' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.is_mandatory',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'must_be_correct' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.must_be_correct',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'answers' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.answers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_kequestionnaire_domain_model_answer',
                'foreign_field' => 'question',
                'foreign_sortby' => 'sorting',
                'maxitems'      => 9999,
                'appearance' => [
                    'collapseAll' => TRUE,
                    'expandSingle' => TRUE,
                    'levelLinksPosition' => 'both',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'useSortable' => 1
                ],
            ],
        ],
        'random_answers' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.random_answers',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'column_count' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.column_count',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	 => '4',
                'eval'	 => 'int',
                'default'=> 1
            ],
        ],
        'max_answers' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.max_answers',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 0
            ]
        ],
        'min_answers' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.min_answers',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 0
            ]
        ],
        'content_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.content_id',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tt_content',
                'size' => 1,
                'maxitems' => 1
            ],
        ],
        'dependancies' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.dependancies',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_kequestionnaire_domain_model_dependancy',
                'foreign_field' => 'dquestion',
                'maxitems'      => 9999,
                'appearance' => [
                    'collapseAll' => TRUE,
                    'expandSingle' => TRUE,
                    'levelLinksPosition' => 'both',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'useSortable' => 1
                ],
            ],
        ],
        'to_page' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.to_page',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	 => '4',
                'eval'	 => 'int'
            ],
        ],
        'direct_jump' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.direct_jump',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'javascript' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.javascript',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'size' => 1,
                'maxitems' => 1
            ],
        ],
        'only_js' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.only_js',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'css' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.css',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
        'template' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_question.template',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'size' => 1,
                'maxitems' => 1
            ],
        ],
    ],
];
