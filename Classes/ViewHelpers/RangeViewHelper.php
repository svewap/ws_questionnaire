<?php

namespace Kennziffer\KeQuestionnaire\ViewHelpers;

use Kennziffer\KeQuestionnaire\Domain\Repository\RangeRepository;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
class RangeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;


    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * inject signal slots
     *
     * @param \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
     * @return void
     */
    public function injectSignalSlotDispatcher(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }

    /**
     * ranges
     *
     * @var array
     */
    protected $ranges;

    /**
     * Checks for the right Range Texts and stuff to be shown
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Questionnaire $questionnaire
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result
     * @param string $as The name of the iteration variable
     * @return string
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function render($questionnaire, $result, $as)
    {
        $this->result = $result;
        $this->questionnaire = $questionnaire;

        $this->templateVariableContainer = $this->renderingContext->getVariableProvider();
        if ($result === null) {
            return '';
        }

        $this->output = '';
        //check the Ranges
        $ranges = $this->collectRanges();
        if (is_array($ranges)) {
            foreach ($ranges as $range) {
                $this->templateVariableContainer->add($as, $range);
                $this->output .= $this->renderChildren();
                $this->templateVariableContainer->remove($as);
            }
        }

        return $this->output;
    }

    /**
     * get the Ranges
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array The query result object or an array if $returnRawQueryResult is TRUE
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    private function collectRanges()
    {
        $all_ranges = $this->getRanges();
        if (is_object($all_ranges) || is_array($all_ranges)) {
            /** @var \Kennziffer\KeQuestionnaire\Domain\Model\Range $range */
            foreach ($all_ranges as $range) {
                if ($this->result->getPoints() >= $range->getPointsFrom() && $this->result->getPoints() <= $range->getPointsUntil()) {
                    $this->ranges[$range->getUid()] = $range;
                }
            }
        } else {
            return false;
        }


        $this->signalSlotDispatcher->dispatch(__CLASS__, 'getPremiumRanges', [$this]);
        return $this->ranges;
    }

    /**
     * get the Ranges
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array The query result object or an array if $returnRawQueryResult is TRUE
     */
    private function getRanges()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
        $this->configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ConfigurationManager::class);
        $this->contentObj = $this->configurationManager->getContentObject();
        $uid = $this->contentObj->data['uid'];

        $this->questionnaire = $this->questionnaire->loadFullObject($this->contentObj->data['uid']);
        /** @var \Kennziffer\KeQuestionnaire\Domain\Repository\RangeRepository $rep */
        $rep = $this->objectManager->get(RangeRepository::class);

        $ranges = $rep->findForPid($this->questionnaire->getStoragePid());
        return $ranges;
    }
}
