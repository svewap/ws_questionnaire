<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer',
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
        'searchFields' => 'title,value,text,is_correct_answer,',
        'iconfile' => 'EXT:ke_questionnaire/Resources/Public/Icons/answer.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, text, points, is_correct_answer',
    ],
    'types' => [
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Radiobutton' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, points, is_correct_answer, show_textfield,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Checkbox' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, points, is_correct_answer, show_textfield,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleInput' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, width, pre_text, in_text, post_text, max_chars, validation_type, validation_text, validation_keys_amount, comparison_text,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MultiInput' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, width, height, pre_text, in_text, post_text, validation_type, validation_text, validation_keys_amount, comparison_text,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleSelect' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, select_values, comparison_text,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeText' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeTextDD' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, cloze_add_terms,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeTerm' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, cloze_position,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaImage' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, coords, area_highlight,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaSequence' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, area_highlight,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        //'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaSimpleScale' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, area_highlight,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'),
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDImage' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, area_index,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingInput' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingSelect' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingOrder' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingTerm' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, area_index,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MatrixHeader' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, cols, max_answers, min_answers,template,add_clones,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MatrixRow' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, title_line, show_textfield, template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Slider' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, left_label, right_label, min_value, max_value, slider_increment, width,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SemanticDifferential' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, left_label, right_label, min_value, max_value, slider_increment, show_steps, step_labels, points_start, points_increase, width,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DataPrivacy' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text,template,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
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
                'foreign_table' => 'tx_kequestionnaire_domain_model_answer',
                'foreign_table_where' => 'AND tx_kequestionnaire_domain_model_answer.pid=###CURRENT_PID### AND tx_kequestionnaire_domain_model_answer.sys_language_uid IN (-1,0)',
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
            ],
        ],
        'type' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.Radiobutton', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Radiobutton'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.Checkbox', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Checkbox'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.SingleInput', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleInput'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.MultiInput', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MultiInput'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.SingleSelect', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleSelect'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.ClozeText', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeText'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.ClozeTextDD', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeTextDD'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.ClozeTerm', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\ClozeTerm'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.DDAreaImage', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaImage'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.DDAreaSequence', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaSequence'],
                    //array('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.DDAreaSimpleScale', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaSimpleScale'),
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.DDImage', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDImage'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.RankingInput', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingInput'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.RankingOrder', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingOrder'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.RankingSelect', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingSelect'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.RankingTerm', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\RankingTerm'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.MatrixHeader', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MatrixHeader'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.MatrixRow', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MatrixRow'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.Slider', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Slider'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.SemanticDifferential', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SemanticDifferential'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.DataPrivacy', 'Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DataPrivacy'],
                ],
                'itemsProcFunc' => 'Kennziffer\\KeQuestionnaire\\Utility\\TCAAnswerType->checkTypes',
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => 'Kennziffer\\KeQuestionnaire\\Domain\\Model\\AnswerType\\Checkbox',
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'points' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.points',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'checkbox' => '0',
                'range'	=> [
                    'upper' => '1000',
                    'lower' => '-1000'
                ],
                'default' => 0
            ]
        ],
        'points_start' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.points_start',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'checkbox' => '0',
                'range'	=> [
                    'upper' => '1000',
                    'lower' => '-1000'
                ],
                'default' => 0
            ]
        ],
        'points_increase' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.points_increase',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'checkbox' => '0',
                'range'	=> [
                    'upper' => '1000',
                    'lower' => '-1000'
                ],
                'default' => 0
            ]
        ],
        'text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            //  'richtextConfiguration' => 'jve_template',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
            // 'defaultExtras' => '',
        ],
        'is_correct_answer' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.is_correct_answer',
            'config' => [
                'type' => 'check',
            ],
        ],
        'question' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'width' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.width',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int'
            ]
        ],
        'height' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.height',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int'
            ]
        ],
        'pre_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.pre_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'in_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.in_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'post_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.post_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'max_chars' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.max_chars',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 0
            ]
        ],
        'validation_type' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.none', ''],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.numeric', 'numeric'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.integer', 'integer'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.date', 'date'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.email', 'email'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.compareText', 'compareText'],
                    ['LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_type.keywords', 'keywords'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => '',
            ],
        ],
        'validation_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'validation_keys_amount' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.validation_keys_amount',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 0
            ]
        ],
        'comparison_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.comparison_text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'cloze_position' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.cloze_position',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 1,
            ],
        ],
        'cloze_add_terms' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.cloze_add_terms',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'image' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.image',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_kequestionnaire',
                'show_thumbs' => 1,
                'size' => 1,
                'maxitems' => 1,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
            ],
        ],
        'coords' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.coords',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
                'wizards' => [
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'edit' => [
                        'type' => 'popup',
                        'title' => 'Create Image Area Coordinates',
                        'module' => [
                            'name' => 'wizard_imageAreaSelect',
                        ],
                        'icon' => 'EXT:ke_questionnaire/Resources/Public/Icons/imageAreaSelectWizard.png',
                        'JSopenParams' => 'height=800,width=900,status=0,menubar=0,scrollbars=1',
                    ],
                ],
            ],
        ],
        'area_index' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.area_index',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int'
            ],
        ],
        'area_highlight' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.area_highlight',
            'config' => [
                'type' => 'check',
                'default' => true
            ],
        ],
        'answer' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'cols' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.cols',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_kequestionnaire_domain_model_answer',
                'foreign_field' => 'answer',
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
        'show_textfield' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.show_textfield',
            'config' => [
                'type' => 'check',
            ],
        ],
        'max_answers' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.max_answers',
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
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.min_answers',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 0
            ]
        ],
        'select_values' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.select_values',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'left_label' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.left_label',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'right_label' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.right_label',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'min_value' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.min_value',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 0
            ]
        ],
        'max_value' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.max_value',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int',
                'default' => 10
            ]
        ],
        'slider_increment' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.slider_increment',
            'config' => [
                'type'	 => 'input',
                'size'	 => '10',
                'max'	  => '10',
                'eval'	 => 'float',
                'default' => '1.0000'
            ]
        ],
        'show_steps' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.show_steps',
            'config' => [
                'type' => 'check',
            ],
        ],
        'step_labels' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.step_labels',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'source_dir' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.source_dir',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'destination_dir' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.destination_dir',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'avatar_parts' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.avatar_parts',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'feuser_field' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.feuser_field',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'template' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.template',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'size' => 1,
                'maxitems' => 1
            ],
        ],
        'add_clones' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.add_clones',
            'config' => [
                'type' => 'check',
            ],
        ],
        'title_line' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.title_line',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
];
