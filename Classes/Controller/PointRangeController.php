<?php

namespace Kennziffer\KeQuestionnaire\Controller;

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
 * This Class renders the valuation charts
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PointRangeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \Kennziffer\KeQuestionnaire\Domain\Repository\RangeRepository
     */
    protected $rangeRepository;

    /**
     * inject range repository
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Repository\RangeRepository $rangeRepository
     * @return void
     */
    public function injectRangeRepository(\Kennziffer\KeQuestionnaire\Domain\Repository\RangeRepository $rangeRepository
    ) {
        $this->rangeRepository = $rangeRepository;
    }

    /**
     * action show text for range
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result A fresh new result object
     * @return void
     */
    public function showTextAction(\Kennziffer\KeQuestionnaire\Domain\Model\Result $result)
    {
        $ranges = $this->rangeRepository->findAll();
        if ($ranges !== null) {
            /* @var $range \Kennziffer\KeQuestionnaire\Domain\Model\Range */
            foreach ($ranges as $range) {
                if ($result->getPoints() >= $range->getPointsFrom() && $result->getPoints() <= $range->getPointsUntil()) {
                    $resultText = $range->getText();
                    break;
                }
            }
        }
        $this->view->assign('result', $result);
        $this->view->assign('resultText', $resultText);
    }
}
