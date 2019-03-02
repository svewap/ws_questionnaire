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
 * Test case for class Tx_KeQuestionnaire_Domain_Model_Result.
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
class Tx_KeQuestionnaire_Domain_Model_ResultTest extends Tx_Extbase_Tests_Unit_BaseTestCase
{
    /**
     * @var Tx_KeQuestionnaire_Domain_Model_Result
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new Tx_KeQuestionnaire_Domain_Model_Result();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function getFinishedReturnsInitialValueForInteger()
    {
        $this->assertSame(
            0,
            $this->fixture->getFinished()
        );
    }

    /**
     * @test
     */
    public function setFinishedForIntegerSetsFinished()
    {
        $this->fixture->setFinished(12);

        $this->assertSame(
            12,
            $this->fixture->getFinished()
        );
    }

    /**
     * @test
     */
    public function getQuestionsReturnsInitialValueForObjectStorageContainingTx_KeQuestionnaire_Domain_Model_ResultQuestion(
    )
    {
        $newObjectStorage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getQuestions()
        );
    }

    /**
     * @test
     */
    public function setQuestionsForObjectStorageContainingTx_KeQuestionnaire_Domain_Model_ResultQuestionSetsQuestions()
    {
        $question = new Tx_KeQuestionnaire_Domain_Model_ResultQuestion();
        $objectStorageHoldingExactlyOneQuestions = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingExactlyOneQuestions->attach($question);
        $this->fixture->setQuestions($objectStorageHoldingExactlyOneQuestions);

        $this->assertSame(
            $objectStorageHoldingExactlyOneQuestions,
            $this->fixture->getQuestions()
        );
    }

    /**
     * @test
     */
    public function addQuestionToObjectStorageHoldingQuestions()
    {
        $question = new Tx_KeQuestionnaire_Domain_Model_ResultQuestion();
        $objectStorageHoldingExactlyOneQuestion = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingExactlyOneQuestion->attach($question);
        $this->fixture->addQuestion($question);

        $this->assertEquals(
            $objectStorageHoldingExactlyOneQuestion,
            $this->fixture->getQuestions()
        );
    }

    /**
     * @test
     */
    public function removeQuestionFromObjectStorageHoldingQuestions()
    {
        $question = new Tx_KeQuestionnaire_Domain_Model_ResultQuestion();
        $localObjectStorage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        $localObjectStorage->attach($question);
        $localObjectStorage->detach($question);
        $this->fixture->addQuestion($question);
        $this->fixture->removeQuestion($question);

        $this->assertEquals(
            $localObjectStorage,
            $this->fixture->getQuestions()
        );
    }

}
