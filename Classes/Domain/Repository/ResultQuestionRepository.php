<?php

namespace Kennziffer\KeQuestionnaire\Domain\Repository;

use Kennziffer\KeQuestionnaire\Domain\Model\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\Result;

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
class ResultQuestionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param Question $question
     * @param Result $result
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface All finished results
     */
    public function findByQuestionAndResult($question, $result)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraint = $query->equals('result', $result);
        $constraint = $query->logicalAnd([
            $query->equals('question', $question),
            $constraint
        ]);
        $query->matching($constraint);
        return $query->execute();
    }

    /**
     * @param Question $question
     * @param int $resultId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface All finished results
     */
    public function findByQuestionAndResultId($question, $resultId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraint = $query->equals('result', $resultId);
        $constraint = $query->logicalAnd([
            $query->equals('question', $question),
            $constraint
        ]);
        $query->matching($constraint);
        return $query->execute();
    }

    /**
     * @param Question $question
     * @param Result $result
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface All finished results
     */
    public function findByQuestionAndResultRaw($question, $result)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraint = $query->equals('result', $result);
        $constraint = $query->logicalAnd([
            $query->equals('question', $question),
            $constraint
        ]);
        $query->matching($constraint);
        return $query->execute(true);
    }

    /**
     * @param Question $question
     * @param int $resultId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface All finished results
     */
    public function findByQuestionAndResultIdRaw($question, $resultId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraint = $query->equals('result', $resultId);
        $constraint = $query->logicalAnd([
            $query->equals('question', $question),
            $constraint
        ]);
        $query->matching($constraint);
        return $query->execute(true);
    }

    /**
     * @param int $question
     * @param int $resultId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface All finished results
     */
    public function findByQuestionIdAndResultIdRaw($question, $resultId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraint = $query->equals('result', $resultId);
        $constraint = $query->logicalAnd([
            $query->equals('question', $question),
            $constraint
        ]);
        $query->matching($constraint);
        return $query->execute(true);
    }

    /**
     * get a raw result => no object, only array
     */
    public function findForResultRaw($resultId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('result', $resultId));

        return $query->execute(true);
    }
}
