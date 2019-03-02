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
class Tx_KeQuestionnaire_Validation_EmailTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{

    /**
     * @var Tx_KeQuestionnaire_Validation_Email
     */
    protected $validator;


    public function setUp()
    {
        $this->validator = new Tx_KeQuestionnaire_Validation_Email();
        $this->validator->injectObjectManager(new \TYPO3\CMS\Extbase\Object\ObjectManager());
    }

    public function tearDown()
    {
        unset($this->validator);
    }


    /**
     * @test
     */
    public function validateEmail()
    {
        $result = $this->validator->isValid('info@kennziffer.com');
        $this->assertEquals(true, $result);

        $result = $this->validator->isValid('test@frömken.de');
        $this->assertEquals(true, $result);

        $result = $this->validator->isValid('hallo');
        $this->assertEquals(false, $result);

        $result = $this->validator->isValid('a.b@c.d');
        $this->assertEquals(true, $result);

        $result = $this->validator->isValid('name@domain');
        $this->assertEquals(false, $result);

        $result = $this->validator->isValid('name@localhost');
        $this->assertEquals(false, $result);
    }

}
