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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Ke_questionnaire_Controller_QuestionController.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Questionnaire
 *
 * @author Fabian Friedrich <friedrich@kennziffer.com>
 */
class Tx_Ke_questionnaire_Controller_QuestionControllerTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{
    /**
     * @var Tx_KeQuestionnaire_Domain_Model_Question
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new Tx_KeQuestionnaire_Domain_Model_Question();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function dummyMethod()
    {
        $this->markTestIncomplete();
    }

}
