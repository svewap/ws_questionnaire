<?php use Kennziffer\KeQuestionnaire\Controller\ResultController;

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
 * Test case for class Tx_Ke_questionnaire_Controller_ResultController.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Questionnaire
 *
 * @author Stefan froemken <froemken@kennziffer.com>
 * @author Fabian Friedrich <friedrich@kennziffer.com>
 */
class Tx_Ke_questionnaire_Controller_ResultControllerTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{

    /**
     * @var Tx_KeQuestionnaire_Domain_Model_Result
     */
    protected $formResult;

    /**
     * @var Tx_KeQuestionnaire_Domain_Model_Result
     */
    protected $dbResult;

    /**
     * @var  \Kennziffer\KeQuestionnaire\Controller\ResultController
     */
    protected $resultController;


    public function setUp()
    {
        $this->resultController = $this->getAccessibleMock(ResultController::class);

        // set up some answers
        $answer1 = new Tx_KeQuestionnaire_Domain_Model_Answer();
        $answer1->setIsCorrectAnswer(true);
        $answer1->setPid(75);
        $answer1->setPoints(10);
        $answer1->setText('Text of answer 1');
        $answer1->setTitle('Answer 1');
        $answer1->setType('Tx_KeQuestionnaire_Domain_Model_AnswerType_Radiobutton');
        $answer2 = $answer1;
        $answer2->setText('Text of Answer 2');
        $answer2->setTitle('Answer 2');

        // add answer to object storage
        //$answers = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
        $answers->attach($answer1);

        // set up a question
        $question = new Tx_KeQuestionnaire_Domain_Model_Question();
        $question->setAnswers($answers);
        $question->setHelpText('Help Text');
        $question->setPid(75);
        $question->setShowTitle(false);
        $question->setText('Text of Question 1');
        $question->setTitle('Question 1');
        $question->setType('Tx_KeQuestionnaire_Domain_Model_QuestionType_Question');

        // set up a result answer
        $resultAnswer = new Tx_KeQuestionnaire_Domain_Model_ResultAnswer();
        $resultAnswer->setAnswer($answer1);
        $resultAnswer->setFeCruserId(12);
        $resultAnswer->setPid(75);
        $resultAnswer->setValue('Answer 1');

        // add result answer to object storage
        //$resultAnswers = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
        $resultAnswers->attach($resultAnswer);

        // set up a result question
        $resultQuestion = new Tx_KeQuestionnaire_Domain_Model_ResultQuestion();
        $resultQuestion->setAnswers($resultAnswers);
        $resultQuestion->setFeCruserId(12);
        $resultQuestion->setPid(75);
        $resultQuestion->setPoints(10);
        $resultQuestion->setQuestion($question);

        // set up a new form result
        $this->formResult = new Tx_KeQuestionnaire_Domain_Model_Result();
        $this->formResult->setFinished(time());
        $this->formResult->addQuestion($resultQuestion);

        $this->dbResult = new Tx_KeQuestionnaire_Domain_Model_Result();
        $this->dbResult->addQuestion($resultQuestion);
    }

    public function tearDown()
    {
        unset($this->resultController);
        unset($this->formResult);
        unset($this->dbResult);
    }


    /**
     * @test
     */
    public function addMissingQuestionsToFormResult()
    {
        $result = $this->resultController->addMissingQuestionsToFormResult($this->formResult, $this->dbResult);
        $this->assertCount(3, $result->getQuestions()->count());
    }

}
