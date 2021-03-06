<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer',
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
        'iconfile' => 'EXT:ws_questionnaire/Resources/Public/Icons/answer.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, text, points, is_correct_answer',
    ],
    'types' => [
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Radiobutton::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, points, is_correct_answer, show_textfield,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Checkbox::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, points, is_correct_answer, show_textfield,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\SingleInput::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, width, pre_text, in_text, post_text, max_chars, validation_type, validation_text, validation_keys_amount, comparison_text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\MultiInput::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, width, height, pre_text, in_text, post_text, validation_type, validation_text, validation_keys_amount, comparison_text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\SingleSelect::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, select_values, comparison_text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\ClozeText::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\ClozeTextDD::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text, cloze_add_terms,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\ClozeTerm::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, cloze_position,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DDAreaImage::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, coords, area_highlight,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DDAreaSequence::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, area_highlight,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DDImage::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, area_index,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingInput::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingSelect::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingOrder::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingTerm::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, image, width, height, area_index,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\MatrixHeader::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, cols, max_answers, min_answers,add_clones,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\MatrixRow::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, title_line, show_textfield, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Slider::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, left_label, right_label, min_value, max_value, slider_increment, width,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\SemanticDifferential::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, left_label, right_label, min_value, max_value, slider_increment, show_steps, step_labels, points_start, points_increase, width,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DataPrivacy::class => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, text,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'],
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
                'foreign_table' => 'tx_wsquestionnaire_domain_model_answer',
                'foreign_table_where' => 'AND tx_wsquestionnaire_domain_model_answer.pid=###CURRENT_PID### AND tx_wsquestionnaire_domain_model_answer.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.Radiobutton',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Radiobutton::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.Checkbox',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Checkbox::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.SingleInput',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\SingleInput::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.MultiInput',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\MultiInput::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.SingleSelect',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\SingleSelect::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.ClozeText',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\ClozeText::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.ClozeTextDD',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\ClozeTextDD::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.ClozeTerm',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\ClozeTerm::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.DDAreaImage',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DDAreaImage::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.DDAreaSequence',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DDAreaSequence::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.DDImage',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DDImage::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.RankingInput',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingInput::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.RankingOrder',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingOrder::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.RankingSelect',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingSelect::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.RankingTerm',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\RankingTerm::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.MatrixHeader',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\MatrixHeader::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.MatrixRow',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\MatrixRow::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.Slider',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Slider::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.SemanticDifferential',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\SemanticDifferential::class
                    ],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.type.DataPrivacy',
                        \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\DataPrivacy::class
                    ],
                ],
                'itemsProcFunc' => 'WapplerSystems\\WsQuestionnaire\\Utility\\TCAAnswerType->checkTypes',
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => \WapplerSystems\WsQuestionnaire\Domain\Model\AnswerType\Checkbox::class,
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'points' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.points',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.points_start',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.points_increase',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
            // 'defaultExtras' => '',
        ],
        'is_correct_answer' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.is_correct_answer',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.width',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int'
            ]
        ],
        'height' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.height',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int'
            ]
        ],
        'pre_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.pre_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'in_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.in_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'post_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.post_text',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'max_chars' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.max_chars',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.none', ''],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.numeric', 'numeric'],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.integer', 'integer'],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.date', 'date'],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.email', 'email'],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.compareText', 'compareText'],
                    ['LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_type.keywords', 'keywords'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => '',
                'default' => '',
            ],
        ],
        'validation_text' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'validation_keys_amount' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.validation_keys_amount',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.comparison_text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'cloze_position' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.cloze_position',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.cloze_add_terms',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'image' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.image',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_wsquestionnaire',
                'show_thumbs' => 1,
                'size' => 1,
                'maxitems' => 1,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
            ],
        ],
        'coords' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.coords',
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
                        'icon' => 'EXT:ws_questionnaire/Resources/Public/Icons/imageAreaSelectWizard.png',
                        'JSopenParams' => 'height=800,width=900,status=0,menubar=0,scrollbars=1',
                    ],
                ],
            ],
        ],
        'area_index' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.area_index',
            'config' => [
                'type'	 => 'input',
                'size'	 => '4',
                'max'	  => '4',
                'eval'	 => 'int'
            ],
        ],
        'area_highlight' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.area_highlight',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.cols',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_wsquestionnaire_domain_model_answer',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.show_textfield',
            'config' => [
                'type' => 'check',
            ],
        ],
        'max_answers' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.max_answers',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.min_answers',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.select_values',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'left_label' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.left_label',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'right_label' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.right_label',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'min_value' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.min_value',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.max_value',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.slider_increment',
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
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.show_steps',
            'config' => [
                'type' => 'check',
            ],
        ],
        'step_labels' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.step_labels',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'source_dir' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.source_dir',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'destination_dir' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.destination_dir',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'avatar_parts' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.avatar_parts',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 3,
                'eval' => 'trim',
            ],
        ],
        'feuser_field' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.feuser_field',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'add_clones' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.add_clones',
            'config' => [
                'type' => 'check',
            ],
        ],
        'title_line' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_questionnaire/Resources/Private/Language/locallang_db.xml:tx_wsquestionnaire_domain_model_answer.title_line',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
];
