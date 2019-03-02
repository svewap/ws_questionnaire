<?php use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * Test case for class Tx_KeQuestionnaire_Domain_Model_ResultQuestion.
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
class Tx_KeQuestionnaire_Domain_Model_ResultQuestionTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{
    /**
     * @var Tx_KeQuestionnaire_Domain_Model_ResultQuestion
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new Tx_KeQuestionnaire_Domain_Model_ResultQuestion();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function getAnswersReturnsInitialValueForObjectStorageContainingTx_KeQuestionnaire_Domain_Model_ResultAnswer(
    )
    {
        $newObjectStorage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getAnswers()
        );
    }

    /**
     * @test
     */
    public function setAnswersForObjectStorageContainingTx_KeQuestionnaire_Domain_Model_ResultAnswerSetsAnswers()
    {
        $answer = new Tx_KeQuestionnaire_Domain_Model_ResultAnswer();
        $objectStorageHoldingExactlyOneAnswers = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingExactlyOneAnswers->attach($answer);
        $this->fixture->setAnswers($objectStorageHoldingExactlyOneAnswers);

        $this->assertSame(
            $objectStorageHoldingExactlyOneAnswers,
            $this->fixture->getAnswers()
        );
    }

    /**
     * @test
     */
    public function addAnswerToObjectStorageHoldingAnswers()
    {
        $answer = new Tx_KeQuestionnaire_Domain_Model_ResultAnswer();
        $objectStorageHoldingExactlyOneAnswer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingExactlyOneAnswer->attach($answer);
        $this->fixture->addAnswer($answer);

        $this->assertEquals(
            $objectStorageHoldingExactlyOneAnswer,
            $this->fixture->getAnswers()
        );
    }

    /**
     * @test
     */
    public function removeAnswerFromObjectStorageHoldingAnswers()
    {
        $answer = new Tx_KeQuestionnaire_Domain_Model_ResultAnswer();
        $localObjectStorage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $localObjectStorage->attach($answer);
        $localObjectStorage->detach($answer);
        $this->fixture->addAnswer($answer);
        $this->fixture->removeAnswer($answer);

        $this->assertEquals(
            $localObjectStorage,
            $this->fixture->getAnswers()
        );
    }

    /**
     * @test
     */
    public function getQuestionReturnsInitialValueForTx_KeQuestionnaire_Domain_Model_Question()
    {
    }

    /**
     * @test
     */
    public function setQuestionForTx_KeQuestionnaire_Domain_Model_QuestionSetsQuestion()
    {
    }

}
