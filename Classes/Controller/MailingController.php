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
 * This Class renders the valuation charts
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MailingController extends AbstractController
{

    /**
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\Result
     */
    protected $result;

    /**
     * @var \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    protected $mail;

    /**
     * inject mail
     *
     * @param \Kennziffer\KeQuestionnaire\Utility\Mail $mail
     */
    public function injectMail(\Kennziffer\KeQuestionnaire\Utility\Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * action mail
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result A fresh new result object
     * @return void
     */
    public function mailAction(\Kennziffer\KeQuestionnaire\Domain\Model\Result $result)
    {
        $this->result = $result;
        $this->nextStep($result);
    }
}
