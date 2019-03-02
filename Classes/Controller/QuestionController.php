<?php

namespace Kennziffer\KeQuestionnaire\Controller;

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
class QuestionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * questionRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository
     */
    protected $questionRepository;

    /**
     * injectQuestionRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository $questionRepository
     * @return void
     */
    public function injectQuestionRepository(
        \Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository $questionRepository
    ) {
        $this->questionRepository = $questionRepository;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $questions = $this->questionRepository->findAll();
        $this->view->assign('questions', $questions);
    }

}
