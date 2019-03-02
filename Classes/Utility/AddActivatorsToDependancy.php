<?php

namespace Kennziffer\KeQuestionnaire\Utility;

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;
use Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository;
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
 * creates the Select-Values for the Dependancy-Select in Backend
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AddActivatorsToDependancy
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * questionRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository
     */
    protected $questionRepository;

    /**
     * add items to the select box for activating answers
     *
     * @param mixed $config
     * @return array
     */
    public function addItems($config)
    {
        // allowed answer-Types
        $allowedTypes = ['Checkbox', 'Radiobutton'];
        // get data
        $data = [];
        $questions = $this->getQuestions($config['row']['pid']);

        foreach ($questions as $question) {
            $item = [];
            $item['title'] = $question->getTitle();
            /** @var Answer $answer */
            foreach ($question->getAnswers() as $answer) {
                if (in_array($answer->getShortType(), $allowedTypes)) {
                    $item['uid'] = $answer->getUid();
                    $item['subtitle'] = $answer->getTitle();
                    $data[] = $item;
                }
            }
        }

        // create option list
        $optionList = [];

        foreach ($data as $item) {
            $label = '[' . $item['uid'] . '] ' . $item['title'] . ' - ' . $item['subtitle'];
            $value = $item['uid'];

            $optionList[] = [0 => $label, 1 => $value];
        }

        // return config
        $config['items'] = array_merge($config['items'], $optionList);
        return $config;
    }

    /**
     * get the Questions for the questionnaire
     *
     * @param integer $storagePid
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    private function getQuestions($storagePid)
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
        $this->questionRepository = $this->objectManager->get(QuestionRepository::class);
        return $this->questionRepository->findAllForPid($storagePid);
    }

}
