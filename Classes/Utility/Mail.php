<?php

namespace Kennziffer\KeQuestionnaire\Utility;

use TYPO3\CMS\Core\Mail\MailMessage;

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
class Mail
{

    /**
     * SwiftMailer
     *
     * @var \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected $message = null;

    /**
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\ExtConf
     */
    protected $extConf;


    /**
     * inject swift message
     *
     * @param \TYPO3\CMS\Core\Mail\MailMessage $message
     * @return void
     */
    public function injectSwiftMessage(\TYPO3\CMS\Core\Mail\MailMessage $message)
    {
        $this->message = $message;
    }

    /**
     * inject extConf
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\ExtConf $extConf
     */
    public function injectExtConf(\Kennziffer\KeQuestionnaire\Domain\Model\ExtConf $extConf)
    {
        $this->extConf = $extConf;
    }


    /**
     * Returns the body
     *
     * @return string|array $body
     */
    public function getBody()
    {
        if (!$this->message->getBody()) {
            // if body is not try to get attached children like HTML parts
            if (count($this->message->getChildren())) {
                return $this->message->getChildren();
            } else {
                return '';
            }
        } else {
            return $this->message->getBody();
        }
    }

    /**
     * Sets the body
     *
     * @param string $body
     * @return \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    public function setBody($body)
    {
        $this->message->setBody($body);
        return $this;
    }

    /**
     * Sets the html
     *
     * @param string $html
     * @return \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    public function setHtml($html)
    {
        $this->message->addPart($html, 'text/html');
        return $this;
    }

    /**
     * Returns the subject
     *
     * @return string $subject
     */
    public function getSubject()
    {
        return $this->message->getSubject();
    }

    /**
     * Sets the subject
     *
     * @param string $subject
     * @return \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    public function setSubject($subject)
    {
        $this->message->setSubject($subject);
        return $this;
    }

    /**
     * Returns the from
     *
     * @return string $from
     */
    public function getFrom()
    {
        return $this->message->getFrom();
    }

    /**
     * Sets the from
     *
     * @param string $from The from email address
     * @param string $name The from name
     * @return \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    public function setFrom($from, $name = null)
    {
        $this->message->setFrom($from, $name);
        return $this;
    }

    /**
     * Returns the receivers
     *
     * @return array $receivers
     */
    public function getReceivers()
    {
        return $this->message->getTo();
    }

    /**
     * Sets the receivers
     * By using this method the key should be the mail address
     *
     * @param array $receivers
     * @return \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    public function setReceivers($receivers)
    {
        $this->message->setTo($receivers);
        return $this;
    }

    /**
     * Add a receiver
     *
     * @param string $receiver The receivers email address
     * @param string $name The receivers name
     * @return \Kennziffer\KeQuestionnaire\Utility\Mail
     */
    public function addReceiver($receiver, $name = null)
    {
        $this->message->addTo($receiver, $name);
        return $this;
    }

    /**
     * send mail
     *
     * @return integer amount of valid receivers
     * @throws \Kennziffer\KeQuestionnaire\Exception
     */
    public function sendMail()
    {
        if ($this->validateMessage()) {
            $number = $this->message->send();
            $this->message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(MailMessage::class);
            return $number;
        } else {
            return 0;
        }
    }

    /**
     * validate message
     *
     * @return boolean
     * @throws \Kennziffer\KeQuestionnaire\Exception
     */
    protected function validateMessage()
    {
        if (!$this->getFrom()) {
            // first: try to get an alternative mail address and sender name from extConf
            if ($this->extConf->getEmailAddress()) {
                if ($this->extConf->getEmailSender()) {
                    $this->setFrom($this->extConf->getEmailAddress(), $this->extConf->getEmailSender());
                } else {
                    $this->setFrom($this->extConf->getEmailAddress());
                }
            } else {
                // second: try to get an alternative mail address and sender name from INSTALL_TOOL
                if (empty($GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'])) {
                    // third: no email address found. EXIT
                    throw new \Kennziffer\KeQuestionnaire\Exception('mailNoFrom', 1349702098);
                } else {
                    if (empty($GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'])) {
                        $this->setFrom($GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress']);
                    } else {
                        $this->setFrom($GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'],
                            $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName']);
                    }
                }
            }
        }
        if (count($this->getReceivers()) === 0) {
            throw new \Kennziffer\KeQuestionnaire\Exception('mailNoReceivers', 1349702831);
        }
        if (!$this->getSubject()) {
            throw new \Kennziffer\KeQuestionnaire\Exception('mailNoSubject', 1349702835);
        }
        if (!$this->getBody()) {
            throw new \Kennziffer\KeQuestionnaire\Exception('mailNoBody', 1349702840);
        }
        return true;
    }
}

