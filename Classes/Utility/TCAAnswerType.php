<?php

namespace Kennziffer\KeQuestionnaire\Utility;

use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Checkbox;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\MatrixHeader;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\Radiobutton;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleInput;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleSelect;
use Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Kennziffer.com <info@kennziffer.com>, www.kennziffer.com
 *  (c) 2019 WapplerSystems <typo3YYYY@wappler.systems>, www.wappler.systems
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TCAAnswerType
{
    /**
     * check Fields funktion for dynamic answer types as for matrix headers
     *
     * @param array $params
     * @param array $conf
     * @return array $config
     */
    public function checkTypes($params, $conf)
    {
        //get the cached TSconfig data for elements. This will show the preloaded elements
        //simple question->answer will show
        // 0 => question, 1=>new answer
        //matrix header will show
        // 0 => question, 1=> header, 2=> new answer
        $uids = [];
        if (is_array($conf->cachedTSconfig)) {
            foreach ($conf->cachedTSconfig as $key => $cache) {
                $data = explode(':', $key);
                //only store uids of answers
                if ($data[0] == 'tx_kequestionnaire_domain_model_answer') {
                    $uids[] = $cache['_THIS_UID'];
                } //store the question uid => may be needed in later programming
                else {
                    if ($data[0] == 'tx_kequestionnaire_domain_model_question') {
                        $qUid = $cache['_THIS_UID'];
                    }
                }
            }
        }
        //if more than one answer is found => more depth than question->answer
        //get the base element
        if (count($uids) > 1) {
            $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
            $rep = $this->objectManager->get(AnswerRepository::class);
            //baseElement for is the last element before the newly added
            $baseElement = $rep->findByUid($uids[count($uids) - 2]);
        }

        if ($baseElement)
            switch ($baseElement->getShortType()) {
                //MatrixHeader can only show
                // - Radiobutton
                // - Checkbox
                // - SingleInput
                // - SingleSelect
                case 'MatrixHeader':
                    $params['items'] = [
                        [1 => Radiobutton::class,
                            0 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.Radiobutton',
                                'ke_questionnaire')
                        ],
                        [1 => Checkbox::class,
                            0 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.Checkbox',
                                'ke_questionnaire')
                        ],
                        [1 => SingleInput::class,
                            0 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.SingleInput',
                                'ke_questionnaire')
                        ],
                        [1 => SingleSelect::class,
                            0 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.SingleSelect',
                                'ke_questionnaire')
                        ]
                    ];
                    break;
                //ExtendendMatrixHeader can only show
                // - MatrixHeader
                case 'ExtendedMatrixHeader':
                    $params['items'] = [
                        [1 => MatrixHeader::class,
                            0 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:ke_questionnaire/Resources/Private/Language/locallang_db.xml:tx_kequestionnaire_domain_model_answer.type.MatrixHeader',
                                'ke_questionnaire')
                        ],
                    ];
                    $params['default'] = MatrixHeader::class;
                    break;
            };

        return $params;
    }
}

