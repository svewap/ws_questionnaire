<?php

namespace WapplerSystems\WsQuestionnaire\Domain\Repository;

use WapplerSystems\WsQuestionnaire\Domain\Model\AuthCode;

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
class AuthCodeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Returns a query for objects of this repository
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     * @api
     */
    public function createQuery()
    {
        $query = parent::createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query;
    }


    /**
     * find authcodes for a pid
     *
     * @param integer $pid
     * @return AuthCode[]|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllForPid($pid)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('pid', $pid));
        return $query->execute();
    }

    /**
     * find one for string and pid
     *
     * @param string $code
     * @param integer $pid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByAuthCodeForPid($code, $pid)
    {
        $query = $this->createQuery();
        $pid_cond = $query->equals('pid', $pid);
        $code_cond = $query->equals('auth_code', $code);
        $query->matching($query->logicalAnd([$pid_cond, $code_cond]));
        return $query->execute();
    }

    /**
     * @param $code
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByAuthCode($code) {
        $query = $this->createQuery();
        $query->matching($query->equals('auth_code', $code));
        return $query->execute();
    }

    /**
     * find all results for pid
     *
     * @param integer $pid
     * @return int
     */
    public function countAllForPid($pid)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('pid', $pid));
        return $query->count();
    }
}
