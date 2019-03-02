<?php

namespace Kennziffer\KeQuestionnaire\Ajax;

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
class AnswerValidation extends AbstractAjax
{

    /**
     * answerRepository
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository
     */
    protected $answerRepository;

    /**
     * lokalization
     *
     * @var \Kennziffer\KeQuestionnaire\Utility\Localization
     */
    protected $localization;


    /**
     * injectAnswerRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\answerRepository $answerRepository
     * @return void
     */
    public function injectAnswerRepository(
        \Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository $answerRepository
    ) {
        $this->answerRepository = $answerRepository;
    }

    /**
     * injectAnswerRepository
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\Localization $localization
     * @return void
     */
    public function injectLocalization(\Kennziffer\KeQuestionnaire\Utility\Localization $localization)
    {
        $this->localization = $localization;
    }

    /**
     * process an ajax request
     *
     * @param array $arguments If you want, you can add some arguments to your object
     * @return string In most cases JSON
     */
    public function processAjaxRequest(array $arguments)
    {
        /* @var $answer \Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\SingleInput */
        $answer = $this->answerRepository->findByUid($arguments['answerUid']);
        if ($answer === null) {
            return '';
        }
        // the validation Array should contain
        // error => 0 no error / 1 error
        // info => textmessage to be displayed
        $validation = [];

        //in the typoscript settings you can define the pattern for the validation types
        //example:
        // validation {
        //		date = d.m.Y
        //		numeric = ,
        //		email = name@domain.end
        //	}
        $answer->pattern = $this->settings['answer']['validation'][$answer->getValidationType()];
        if ($answer->isValid($arguments['value'])) {
            $validation['error'] = 0;
            $validation['info'] = '';
        } else {
            $validation['error'] = 1;
            $validation['info'] = $this->localization->translate('answerValidation.' . $answer->getValidationType()) . ' ' . $this->settings['answer']['validation'][$answer->getValidationType()];
        }

        $json = $this->convertValueToJson($validation);
        return trim($json);
    }

}
