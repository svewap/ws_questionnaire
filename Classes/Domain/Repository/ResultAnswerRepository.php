<?php

namespace Kennziffer\KeQuestionnaire\Domain\Repository;

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

use Kennziffer\KeQuestionnaire\Domain\Model\Answer;
use Kennziffer\KeQuestionnaire\Domain\Model\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\Result;

/**
 *
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ResultAnswerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * get a raw result => no object, only array
     * @param $questionId
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findForResultQuestionRaw($questionId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('resultquestion', $questionId));

        return $query->execute(true);
    }

    /**
     * get a raw result => no object, only array
     * @param $questionId
     * @param $answerId
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findForResultQuestionAndAnswerRaw($questionId, $answerId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraint = $query->equals('resultquestion', $questionId);
        $constraint = $query->logicalAnd([
            $query->equals('answer', $answerId),
            $constraint
        ]);
        $query->matching($constraint);
        return $query->execute(true);
    }

    /**
     * find resultanswer for answer
     */
    public function findForAnswer($answer)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('answer', $answer));
        return $query->execute();
    }

    /**
     * get a raw result => no object, only array
     */
    public function findForAnswerRaw($answer)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('answer', $answer));
        return $query->execute(true);
    }

    /**
     * count given answers
     * @param Answer $answer
     * @return int
     */
    public function countResultAnswersForAnswer(Answer $answer)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('answer', $answer));
        return $query->count();
    }

    /**
     * count given answers
     * @param Answer $answer
     * @return int
     */
    public function countResultAnswersForAnswerAndValue(Answer $answer)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->matching($query->logicalAnd([
            $query->equals('answer', $answer),
            $query->equals('value', $answer->getUid())
        ]));

        return $query->count();
    }

    /**
     * get specific Result Answer
     *
     * @param Question $question
     * @param Result $result
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getResultAnswersForQuestionAndResult(Question $question, Result $result
    ) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('question', $question));
        return $query->execute();
    }

    /**
     *
     * @param Answer $row
     * @param string $value
     * @return integer
     */
    public function countResultAnswersForRowAndValue(Answer $row, $value)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->logicalAnd([$query->equals('answer', $row), $query->equals('value', $value)]));
        return $query->count();
    }

    /**
     *
     * @param Answer $row
     * @param string $value
     * @return integer
     */
    public function countResultAnswersForRowAndCol(Answer $row, $value)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->logicalAnd([$query->equals('answer', $row), $query->equals('col', $value)]));

        return $query->count();
    }

    /**
     *
     * @param Answer $row
     * @param string $value
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getResultAnswersForRowAndCol(Answer $row, $value)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->logicalAnd([$query->equals('answer', $row), $query->equals('col', $value)]));

        return $query->execute();
    }

    /**
     *
     * @param Answer $row
     * @param string $value
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getResultAnswersForRowAndColRaw(Answer $row, $value)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->logicalAnd([$query->equals('answer', $row), $query->equals('col', $value)]));

        return $query->execute(true);
    }

    /**
     * get related result answers to answer
     * @param Answer $answer
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getResultAnswersForAnswer(Answer $answer)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('answer', $answer));

        return $query->execute();
    }
}
