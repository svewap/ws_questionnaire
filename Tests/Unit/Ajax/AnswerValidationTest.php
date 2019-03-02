<?php

use Kennziffer\KeQuestionnaire\Ajax\AnswerValidation;
use Kennziffer\KeQuestionnaire\Domain\Repository\AnswerRepository;
use Kennziffer\KeQuestionnaire\Utility\Localization;

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
class Tx_KeQuestionnaire_Ajax_AnswerValidationTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{

    /**
     * @var Tx_KeQuestionnaire_Ajax_AnswerValidation
     */
    protected $answerValidation;


    public function setUp()
    {
        $this->answerValidation = $this->objectManager->get(AnswerValidation::class);
    }

    public function tearDown()
    {
        unset($this->answerValidation);
    }


    /**
     * @test
     */
    public function testProcessAjaxRequestTrue()
    {
        $answer = $this->getMock('Tx_KeQuestionnaire_Domain_Model_Answer', ['getValidationType', 'isValid'], [], '',
            false);
        $answer
            ->expects($this->any())
            ->method('getValidationType')
            ->will($this->returnValue('compareText'));
        $answer
            ->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(true));

        $answerRepository = $this->getMock(AnswerRepository::class, ['findByUid'], [], '', false);
        $answerRepository
            ->expects($this->any())
            ->method('findByUid')
            ->will($this->returnValue($answer));

        $this->answerValidation->injectAnswerRepository($answerRepository);

        $arguments = [
            'answerUid' => 123,
            'value' => 'Hello world'
        ];

        $json = $this->answerValidation->processAjaxRequest($arguments);
        $this->assertEquals('{"error":0,"info":""}', $json);
    }

    /**
     * @test
     */
    public function testProcessAjaxRequestFalseNumeric()
    {
        $answer = $this->getMock('Tx_KeQuestionnaire_Domain_Model_Answer', ['getValidationType', 'isValid'], [], '',
            false);
        $answer
            ->expects($this->any())
            ->method('getValidationType')
            ->will($this->returnValue('numeric'));
        $answer
            ->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(false));

        $answerRepository = $this->getMock(AnswerRepository::class, ['findByUid'], [], '', false);
        $answerRepository
            ->expects($this->any())
            ->method('findByUid')
            ->will($this->returnValue($answer));
        $localization = $this->getMock(Localization::class, ['translate']);
        $localization
            ->expects($this->any())
            ->method('translate')
            ->will($this->returnValue('Only numeric allowed'));

        $this->answerValidation->injectAnswerRepository($answerRepository);
        $this->answerValidation->injectLocalization($localization);

        $arguments = [
            'answerUid' => 123,
            'value' => 'Hello world'
        ];

        $json = $this->answerValidation->processAjaxRequest($arguments);
        $this->assertEquals('{"error":1,"info":"Only numeric allowed"}', $json);
    }

}
