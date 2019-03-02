<?php

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
class Tx_KeQuestionnaire_Validation_KeywordsTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{

    /**
     * @var Tx_KeQuestionnaire_Validation_Keywords
     */
    protected $validator;


    public function setUp()
    {
        $this->validator = new Tx_KeQuestionnaire_Validation_Keywords();
        $this->validator->injectObjectManager(new \TYPO3\CMS\Extbase\Object\ObjectManager());
    }

    public function tearDown()
    {
        unset($this->validator);
    }


    /**
     * @test
     */
    public function validateKeywords()
    {
        $model = new Tx_KeQuestionnaire_Domain_Model_AnswerType_SingleInput();
        $model->setValidationText('hello, you');
        $model->setValidationKeysAmount(2);

        $result = $this->validator->isValid('Hello everybody. I\'m fine...and you?', $model);
        $this->assertEquals(false, $result);

        $result = $this->validator->isValid('hello everybody. I\'m fine...and you?', $model);
        $this->assertEquals(true, $result);

        $result = $this->validator->isValid('Hello everybody', $model);
        $this->assertEquals(false, $result);

        $result = $this->validator->isValid('Hello hello.', $model);
        $this->assertEquals(true, $result);
    }

}
