<?php

namespace Kennziffer\KeQuestionnaire\Domain\Model;

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

use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Group;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Html;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\PageBreak;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Text;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Typo3Content;
use Kennziffer\KeQuestionnaire\Domain\Repository\AuthCodeRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\QuestionnaireRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\QuestionRepository;
use Kennziffer\KeQuestionnaire\Domain\Repository\ResultRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Service\FlexFormService;

/**
 * This Model is not connected to DB
 * It contains all questions and can deliver some additional informations
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Questionnaire extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Questions
     *
     * @var QueryResultInterface
     */
    protected $questions;

    /**
     * QuestionsByPage  JVE: Nov. 2016:
     * Jörg velletti changed TYPE from 'protected' to 'public' to be able to overwrite in serviceSlot!!!
     *
     * @var array
     */
    public $questionsByPage;

    /**
     * page
     *
     * @var int
     */
    protected $page;

    /**
     * requested page
     *
     * @var int
     */
    protected $requestedPage;

    /**
     * settings
     *
     * @var array
     */
    var $settings;

    /**
     * uid
     * @var int
     */
    protected $uid;
    /**
     * pid
     * @var int
     */
    protected $pid;
    /**
     * sorting
     * @var int
     */
    protected $sorting;
    /**
     * header
     * @var string
     *
     */
    protected $header;
    /**
     * headerLink
     * @var string
     *
     */
    protected $headerLink;
    /**
     * bodytext
     * @var string
     *
     */
    protected $bodytext;
    /**
     * image
     * @var string
     *
     */
    protected $image;
    /**
     * imageLink
     * @var string
     *
     */
    protected $imageLink;
    /**
     * colPos
     * @var int
     *
     */
    protected $colPos;
    /**
     * piFlexForm
     * @var string
     *
     */
    protected $piFlexForm;
    /**
     * pages
     * @var string
     *
     */
    protected $pages;
    /**
     * storagePid
     * @var int
     *
     */
    protected $storagePid;

    /**
     * QuestionsForPage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected $questionsForPage;

    /**
     * compareResult
     *
     * @var \Kennziffer\KeQuestionnaire\Domain\Model\Result
     */
    protected $compareResult;


    /**
     * @var int
     */
    private $crdate;

    /**
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param int $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }


    /**
     * each model needs an constructor:
     * http://wiki.typo3.org/Exception/v4/1297759968
     */
    public function __construct()
    {
    }

    /**
     * get all questions for a given page
     *
     * @param int $page
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getQuestionsForPage($page)
    {
        if (isset($this->questionsByPage[$page])) {
            return $this->questionsByPage[$page];
        }
        return $this->questionsForPage;

    }

    /**
     * Returns the amount of pages
     *
     * @return int $countPages
     */
    public function getCountPages()
    {
        return count($this->questionsByPage);
    }

    /**
     * Returns the amount of results
     *
     * @return int $countResults
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getCountResults()
    {
        return $this->countResults(false);
    }

    /**
     * Returns the amount of finished Results
     *
     * @return int $countFinishedResults
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getCountFinishedResults()
    {
        return $this->countResults(true);
    }

    /**
     * Returns the amount of AuthCodes
     *
     * @return int $countAuthCodes
     */
    public function getCountAuthCodes()
    {
        return $this->countAuthCodes();
    }

    /**
     * Returns the id of the next page
     *
     * @return int $nextPage
     */
    public function getNextPage()
    {
        $nextPage = ($this->page + 1);
        if ($nextPage > count($this->questionsByPage)) {
            return $this->page;
        } else {
            return ($this->page + 1);
        }
    }

    /**
     * Returns the id of the previous page
     *
     * @return int $prevPage
     */
    public function getPrevPage()
    {
        if ($this->page === 1) {
            return 1;
        } else {
            return ($this->page - 1);
        }
    }

    /**
     * Returns true if first page
     *
     * @return boolean $isFirstPage
     */
    public function getIsFirstPage()
    {
        return ((int)$this->page === 1);
    }

    /**
     * Returns true if last page
     *
     * @return boolean $isLastPage
     */
    public function getIsLastPage()
    {
        return (count($this->questionsByPage) <= $this->page);
    }

    /**
     * Returns true if the requested Page is equal to the current page
     *
     * @return boolean $isFinishedPage
     */
    public function getIsFinished()
    {
        return $this->requestedPage === $this->page;
    }

    /**
     * Returns the questions
     *
     * @return QueryResultInterface $questions
     */
    public function getQuestions()
    {
        if (count($this->questions) === 0) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            /** @var QuestionRepository $rep */
            $rep = $objectManager->get(QuestionRepository::class);
            $this->setQuestions($rep->findAllForPid($this->getStoragePid()));
        }
        return $this->questions;
    }

    /**
     * Returns the questions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $questions
     */
    public function getSelectQuestions()
    {
        $qStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        foreach ($this->getQuestions() as $question) {
            if ($question instanceof Question) {
                $qStorage->attach($question);
            }
        }

        return $qStorage;
    }

    /**
     * Returns the questions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $questions
     */
    public function getNavigationQuestions()
    {
        /** @var ObjectStorage $qStorage */
        $qStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        foreach ($this->questions as $question) {
            if ($question instanceof Question || $question instanceof Group) {
                $qStorage->attach($question);
            }
        }
        return $qStorage;
    }

    /**
     * Returns the questions
     *
     * @return array $pages
     */
    public function getNavigationPages()
    {
        $pages = [];

        for ($i = 1; $i <= $this->getCountPages(); $i++) {
            $pages[] = $i;
        }

        return $pages;
    }

    /**
     * Sets the questions
     * add seperates all questions by page
     *
     * @param QueryResultInterface $questions
     * @return void
     */
    public function setQuestions(QueryResultInterface $questions)
    {
        $questions = $this->checkNumbering($questions);
        $this->questions = $questions;
        $this->questionsByPage = [];

        if ($questions->count()) {
            $page = 1;
            $pageStorage = GeneralUtility::makeInstance(ObjectStorage::class);

            // seperate all questions for each page
            foreach ($questions as $question) {
                if ($question instanceof PageBreak) {
                    $pageStorage = GeneralUtility::makeInstance(ObjectStorage::class);
                    $page++;
                    continue;
                }
                $pageStorage->attach($question);
                $this->questionsByPage[$page] = $pageStorage;
            }
        }
    }

    /**
     * Checks the Numbering of the Questions in the Questionnaire
     *
     * @param QueryResultInterface $questions
     * @return QueryResultInterface $questions
     */
    private function checkNumbering(QueryResultInterface $questions)
    {
        //create numbering only if there are any questions
        if ($questions->count()) {
            //pages start with 1 => page 0 would be the intro-page
            $page = 1;

            $questionCounter = 0;
            $groupCounter = 0;
            $group = null;
            //check through all questions
            foreach ($questions as $question) {
                //if there is a page-break, start a new page
                if ($question instanceof PageBreak) {
                    $page++;
                    continue;
                }
                //set the page
                $question->setPage($page);
                //check for groups
                if ($question instanceof Group) {
                    if ($this->settings['questionNumbering'] === 'groupedQuestions' || $this->settings['questionNumbering'] === 'grouped') {
                        $questionCounter = 0;
                        $groupCounter++;
                        $question->setNumbering($groupCounter);
                    }
                    $group = $question;
                }
                //create numbering for HTML, Question, Text, Typo3Content
                if ($question instanceof Question
                    || $question instanceof Html
                    || $question instanceof Text
                    || $question instanceof Typo3Content
                ) {
                    //set a group
                    $question->setGroup($group);
                    //check for numbering-type
                    switch ($this->settings['questionNumbering']) {
                        case 'none':
                            break;
                        case 'all':
                            $questionCounter++;
                            $question->setNumbering($questionCounter);
                            break;
                        case 'questions':
                            if ($question instanceof Question) {
                                $questionCounter++;
                                $question->setNumbering($questionCounter);
                            }
                            break;
                        case 'grouped':
                            $questionCounter++;
                            $question->setNumbering($groupCounter . '.' . $questionCounter);
                            break;
                        case 'groupedQuestions':
                            if ($question instanceof Question) {
                                $questionCounter++;
                                $question->setNumbering($groupCounter . '.' . $questionCounter);
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $questions;
    }

    /**
     * Gets the results of the user and questionnaire
     *
     * @param bool $userId
     * @return array|QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getUserResults($userId = false)
    {
        if (!$userId) {
            $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        }
        if ($userId > 0) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            /** @var Typo3QuerySettings $querySettings */
            $querySettings = $objectManager->get(Typo3QuerySettings::class);
            $querySettings->setRespectStoragePage(false);
            /** @var ResultRepository $resultRepository */
            $resultRepository = $objectManager->get(ResultRepository::class);
            $resultRepository->setDefaultQuerySettings($querySettings);
            $results = $resultRepository->findByFeUserAndPid($userId, $this->getStoragePid());

            return $results;
        }
        return [];
    }

    /**
     * Counts the results of the questionnaire
     *
     * @param bool $finished
     * @return int
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function countResults($finished = true)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        /** @var ResultRepository $resultRepository */
        $resultRepository = $objectManager->get(ResultRepository::class);
        $resultRepository->setDefaultQuerySettings($querySettings);
        if ($finished) {
            $counter = $resultRepository->countFinishedForPid($this->getStoragePid());
        } else {
            $counter = $resultRepository->countAllForPid($this->getStoragePid());
        }
        return $counter;
    }

    /**
     * Counts the results of the questionnaire
     *
     * @return int
     */
    public function countAuthCodes(): int
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        /** @var AuthCodeRepository $resultRepository */
        $resultRepository = $objectManager->get(AuthCodeRepository::class);
        $resultRepository->setDefaultQuerySettings($querySettings);
        return $resultRepository->countAllForPid($this->getStoragePid());
    }


    /**
     * Returns the page
     *
     * @return int $page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the page
     *
     * @param int $page
     * @return void
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Returns the requestedPage
     *
     * @return int $requestedPage
     */
    public function getRequestedPage()
    {
        return $this->requestedPage;
    }

    /**
     * Sets the requestedPage
     *
     * @param int $requestedPage
     * @return void
     */
    public function setRequestedPage($requestedPage)
    {
        $this->requestedPage = $requestedPage;
    }

    /**
     * Returns the pid
     *
     * @return int $pid
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Returns the sorting
     *
     * @return int $sorting
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Returns the header
     *
     * @return string $header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Returns the headerLink
     *
     * @return string $headerLink
     */
    public function getHeaderLink()
    {
        return $this->headerLink;
    }

    /**
     * Returns the bodytext
     *
     * @return string $bodytext
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * Returns the image
     *
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Returns the imageLink
     *
     * @return string $imageLink
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * Returns the colPos
     *
     * @return int $colPos
     */
    public function getColPos()
    {
        return $this->colPos;
    }

    /**
     * returns the piFlexForm
     *
     * @return array
     */
    public function getPiFlexForm()
    {
        $ffs = GeneralUtility::makeInstance(FlexFormService::class);
        return $ffs->convertFlexFormContentToArray($this->piFlexForm);
        //return $this->piFlexForm;
    }

    /**
     * Returns the storagePid
     *
     * @return int $storagePid
     */
    public function getStoragePid()
    {
        $pids = explode(',', $this->pages);
        return $pids[0];
    }

    /**
     * Gets the compare Result of the questionnaire
     * this is no actual result but a construct with all the correct / compare answers given in the questions/answers of the questionnaire-storage
     *
     * @return \Kennziffer\KeQuestionnaire\Domain\Model\Result
     */
    public function getCompareResult()
    {
        /** @var Result $result */
        $result = GeneralUtility::makeInstance(Result::class);
        foreach ($this->getQuestions() as $question) {
            /** @var ResultQuestion $rquestion */
            $rquestion = GeneralUtility::makeInstance(ResultQuestion::class);
            $rquestion->setQuestion($question);
            /** @var Answer $answer */
            foreach ($question->getAnswers() as $answer) {
                /** @var ResultAnswer $ranswer */
                $ranswer = GeneralUtility::makeInstance(ResultAnswer::class);
                switch ($answer->getShortType()) {
                    case 'SingleInput':
                    case 'MultiInput':
                    case 'SingleSelect':
                        if ($answer->getComparisonText()) {
                            $ranswer->setAnswer($answer);
                            $ranswer->setValue($answer->getComparisonText());
                        }
                        break;
                    case 'Radiobutton':
                        if ($answer->isCorrectAnswer()) {
                            $ranswer->setAnswer($answer);
                        }
                        break;
                    case 'Checkbox':
                        if ($answer->isCorrectAnswer()) {
                            $ranswer->setAnswer($answer);
                            $ranswer->setValue($answer->getUid());
                        }
                        break;
                    default :
                        break;
                }
                $rquestion->addAnswer($ranswer);
            }
            $result->addQuestion($rquestion);
        }
        return $result;
    }

    /**
     * load the full Questionnaire Object
     *
     * @param int $uid
     * @return Questionnaire
     */
    public function loadFullObject($uid)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var QuestionnaireRepository $rep */
        $rep = $objectManager->get(QuestionnaireRepository::class);
        return $rep->findForUid($uid);
    }

    /**
     * @param array $questionsByPage
     */
    public function setShuffledQuestionsByPage($questionsByPage, $page)
    {
        //  echo "<br>Line: " . __LINE__ . " : " . " File: " . __FILE__ . '<br>$page : ' . var_export($page, TRUE) . "<hr>";

        $this->questionsByPage[$page] = $questionsByPage;
    }

}
