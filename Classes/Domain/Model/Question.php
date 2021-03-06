<?php

namespace WapplerSystems\WsQuestionnaire\Domain\Model;

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
 * @package ws_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Type
     *
     * @var string
     */
    protected $type;

    /**
     * Numbering
     *
     * @var string
     */
    protected $numbering;

    /**
     * Page
     *
     * @var integer
     */
    protected $page;

    /**
     * Group
     *
     * @var \WapplerSystems\WsQuestionnaire\Domain\Model\QuestionType\Group
     */
    protected $group;

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Show title
     *
     * @var string
     */
    protected $showTitle;
    /**
     * Text
     *
     * @var string
     */
    protected $text;

    /**
     * Help Text
     *
     * @var string
     */
    protected $helpText;

    /**
     * Fal media items
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $media;

    /**
     * Media position
     *
     * @var string
     */
    protected $mediaPosition;

    /**
     * Is mandatory
     *
     * @var boolean
     */
    protected $isMandatory = false;

    /**
     * Have the question to be answered correctly?
     *
     * @var boolean
     */
    protected $mustBeCorrect = false;

    /**
     * Answers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\WapplerSystems\WsQuestionnaire\Domain\Model\Answer>
     * @lazy
     * @cascade remove
     */
    protected $answers;

    /**
     * Dependencies
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\WapplerSystems\WsQuestionnaire\Domain\Model\Dependency>
     * @lazy
     * @cascade remove
     */
    protected $dependencies;

    /**
     * Css
     *
     * @var string
     */
    protected $css;

    /**
     * Template
     *
     * @var string
     */
    protected $template;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->answers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->dependencies = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the _localizedUid
     *
     * @return integer $_localizedUid
     */
    public function getLocalizedUid()
    {
        return $this->_localizedUid;
    }

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the short version of type
     * type is the complete class name, but for partials it's better to have shorter type names
     *
     * @return string $shortType
     */
    public function getShortType()
    {
        return substr(strrchr($this->type, '\\'), 1);
    }

    /**
     * Returns the page
     *
     * @return integer $page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the page
     *
     * @param integer $page
     * @return void
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Returns the numbering
     *
     * @return string $numbering
     */
    public function getNumbering()
    {
        return $this->numbering;
    }

    /**
     * Sets the numbering
     *
     * @param string $numbering
     * @return void
     */
    public function setNumbering($numbering)
    {
        $this->numbering = $numbering;
    }

    /**
     * Returns the group
     *
     * @return \WapplerSystems\WsQuestionnaire\Domain\Model\QuestionType\Group $group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Sets the group
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\QuestionType\Group $group
     * @return void
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the showTitle
     *
     * @return string $showTitle
     */
    public function getShowTitle()
    {
        return $this->showTitle;
    }

    /**
     * Sets the showTitle
     *
     * @param string $showTitle
     * @return void
     */
    public function setShowTitle($showTitle)
    {
        $this->showTitle = $showTitle;
    }

    /**
     * Returns the text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     *
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Returns the helpText
     *
     * @return string $helpText
     */
    public function getHelpText()
    {
        return $this->helpText;
    }

    /**
     * Sets the helpText
     *
     * @param string $helpText
     * @return void
     */
    public function setHelpText($helpText)
    {
        $this->helpText = $helpText;
    }


    /**
     * Returns the isMandatory
     *
     * @return boolean $isMandatory
     */
    public function getIsMandatory()
    {
        return (boolean)$this->isMandatory;
    }

    /**
     * Sets the isMandatory
     *
     * @param boolean $isMandatory
     * @return void
     */
    public function setIsMandatory($isMandatory)
    {
        $this->isMandatory = $isMandatory;
    }

    /**
     * Returns the boolean state of isMandatory
     *
     * @return boolean
     */
    public function isIsMandatory()
    {
        return $this->getIsMandatory();
    }

    /**
     * Returns the mustBeCorrect
     *
     * @return boolean $mustBeCorrect
     */
    public function getMustBeCorrect()
    {
        return $this->mustBeCorrect;
    }

    /**
     * Sets the mustBeCorrect
     *
     * @param boolean $mustBeCorrect
     * @return void
     */
    public function setMustBeCorrect($mustBeCorrect)
    {
        $this->mustBeCorrect = $mustBeCorrect;
    }

    /**
     * Returns the boolean state of mustBeCorrect
     *
     * @return boolean
     */
    public function isMustBeCorrect()
    {
        return $this->getMustBeCorrect();
    }

    /**
     * Adds a Answer
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Answer $answer
     * @return void
     */
    public function addAnswer(\WapplerSystems\WsQuestionnaire\Domain\Model\Answer $answer)
    {
        $this->answers->attach($answer);
    }

    /**
     * Removes a Answer
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Answer $answerToRemove The Answer to be removed
     * @return void
     */
    public function removeAnswer(\WapplerSystems\WsQuestionnaire\Domain\Model\Answer $answerToRemove)
    {
        $this->answers->detach($answerToRemove);
    }

    /**
     * Returns the answers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage|Answer[] $answers
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Sets the answers
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers
     * @return void
     */
    public function setAnswers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers)
    {
        $this->answers = $answers;
    }

    /**
     * Adds a Dependency
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Dependency $dependency
     * @return void
     */
    public function addDependency(\WapplerSystems\WsQuestionnaire\Domain\Model\Dependency $dependency)
    {
        $this->dependencies->attach($dependency);
    }

    /**
     * Removes a Dependency
     *
     * @param \WapplerSystems\WsQuestionnaire\Domain\Model\Dependency $dependencyToRemove The Dependency to be removed
     * @return void
     */
    public function removeDependency(\WapplerSystems\WsQuestionnaire\Domain\Model\Dependency $dependencyToRemove)
    {
        $this->dependencies->detach($dependencyToRemove);
    }

    /**
     * Returns the dependencies
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $dependencies
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Sets the dependencies
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $dependencies
     * @return void
     */
    public function setDependencies(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * Checks the dependencies
     *
     * @return boolean
     */
    public function isDependent() : bool
    {
        return $this->getIsDependent();
    }

    public function getIsDependent() : bool
    {
        return count($this->dependencies) > 0;
    }

    /**
     * Returns the css
     *
     * @return string $css
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Sets the css
     *
     * @param string $css
     * @return void
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * Returns the template
     *
     * @return string $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets the template
     *
     * @param string $template
     * @return void
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     *
     * @param Result $result
     * @return boolean
     */
    public function fullfillsDependencies(Result $result): bool
    {
        if ($this->isDependent()) {
            $full = false;
            $fullcount = 0;
            //check all dependencies
            foreach ($this->getDependencies() as $id => $dependency) {
                //get the resultQuestion
                $rQuestion = $result->getResultQuestionForQuestion($dependency->getQuestion());
                if ($rQuestion) {
                    //get the conditions
                    $relConditions = $dependency->getRelationCondition();
                    //check the conditions for all given answers of this resultQuestion
                    foreach ($rQuestion->getAnswers() as $rAnswer) {
                        $fullcount++;
                        if ($rAnswer->getValue() == $relConditions['compareToAnswer']) {
                            switch ($relConditions['type']) {
                                case 'none':
                                    $full = true;
                                    break;
                                case 'and':
                                    if ($full && $fullcount > 1) {
                                        $full = true;
                                    } else {
                                        $full = false;
                                    }
                                    break;
                                case 'or':
                                    $full = true;
                                    break;
                            }
                        }
                    }
                }
            }
            return $full;
        }
        return true;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getMedia(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        return $this->media;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $media
     */
    public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media)
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getMediaPosition(): string
    {
        return $this->mediaPosition;
    }

    /**
     * @param string $mediaPosition
     */
    public function setMediaPosition(string $mediaPosition)
    {
        $this->mediaPosition = $mediaPosition;
    }


}
