<?php

use Kennziffer\KeQuestionnaire\Controller\AjaxController;

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
 * Test case for class Tx_Ke_questionnaire_Controller_ResultAnswerController.
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
class Tx_Ke_questionnaire_Controller_AjaxControllerTest extends UnitTestCase
{

    /**
     * @var  \Kennziffer\KeQuestionnaire\Controller\AjaxController
     */
    protected $ajaxController;


    public function setUp()
    {
        $this->ajaxController = $this->objectManager->get(AjaxController::class);
    }

    public function tearDown()
    {
        unset($this->ajaxController);
    }


    /**
     * @test
     */
    public function ajaxAction()
    {
        $result = $this->ajaxController->ajaxAction('AnswerValidation');
        $this->assertEquals('', $result);

        $result = $this->ajaxController->ajaxAction('tx_phpunit_testcase');
        $this->assertEquals('', $result);

        $result = $this->ajaxController->ajaxAction('trallala');
        $this->assertEquals('', $result);

        $result = $this->ajaxController->ajaxAction(123);
        $this->assertEquals('', $result);
    }

}
