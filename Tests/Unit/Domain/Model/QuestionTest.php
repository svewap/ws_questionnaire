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
 * Test case for class Tx_KeQuestionnaire_Domain_Model_Question.
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
class Tx_KeQuestionnaire_Domain_Model_QuestionTest extends Tx_Extbase_Tests_Unit_BaseTestCase
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
    public function getTitleReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->fixture->setTitle('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function getShowTitleReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function setShowTitleForStringSetsShowTitle()
    {
        $this->fixture->setShowTitle('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getShowTitle()
        );
    }

    /**
     * @test
     */
    public function getTextReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function setTextForStringSetsText()
    {
        $this->fixture->setText('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getText()
        );
    }

    /**
     * @test
     */
    public function getHelpTextReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function setHelpTextForStringSetsHelpText()
    {
        $this->fixture->setHelpText('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getHelpText()
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function setImageForStringSetsImage()
    {
        $this->fixture->setImage('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getImage()
        );
    }

    /**
     * @test
     */
    public function getImagePositionReturnsInitialValueForInteger()
    {
        $this->assertSame(
            0,
            $this->fixture->getImagePosition()
        );
    }

    /**
     * @test
     */
    public function setImagePositionForIntegerSetsImagePosition()
    {
        $this->fixture->setImagePosition(12);

        $this->assertSame(
            12,
            $this->fixture->getImagePosition()
        );
    }

    /**
     * @test
     */
    public function getIsMandatoryReturnsInitialValueForBoolean()
    {
        $this->assertSame(
            true,
            $this->fixture->getIsMandatory()
        );
    }

    /**
     * @test
     */
    public function setIsMandatoryForBooleanSetsIsMandatory()
    {
        $this->fixture->setIsMandatory(true);

        $this->assertSame(
            true,
            $this->fixture->getIsMandatory()
        );
    }

    /**
     * @test
     */
    public function getMustBeCorrectReturnsInitialValueForBoolean()
    {
        $this->assertSame(
            true,
            $this->fixture->getMustBeCorrect()
        );
    }

    /**
     * @test
     */
    public function setMustBeCorrectForBooleanSetsMustBeCorrect()
    {
        $this->fixture->setMustBeCorrect(true);

        $this->assertSame(
            true,
            $this->fixture->getMustBeCorrect()
        );
    }

    /**
     * @test
     */
    public function getAnswersReturnsInitialValueForObjectStorageContainingTx_KeQuestionnaire_Domain_Model_Answer()
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
    public function setAnswersForObjectStorageContainingTx_KeQuestionnaire_Domain_Model_AnswerSetsAnswers()
    {
        $answer = new Tx_KeQuestionnaire_Domain_Model_Answer();
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
        $answer = new Tx_KeQuestionnaire_Domain_Model_Answer();
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
        $answer = new Tx_KeQuestionnaire_Domain_Model_Answer();
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

}
