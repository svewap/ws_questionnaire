<?php

namespace Kennziffer\KeQuestionnaire\Controller;

use Kennziffer\KeQuestionnaire\Evaluation\GoogleChart;

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
class EvaluationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \Kennziffer\KeQuestionnaire\Evaluation\AbstractChart
     */
    protected $chartClass;


    /**
     * initializes this class
     *
     * @return void
     */
    public function initializeAction()
    {
        $class = $this->settings['chart']['class'];
        $this->chartClass = $this->objectManager->get($class);
        if (!$this->chartClass instanceof \Kennziffer\KeQuestionnaire\Evaluation\AbstractChart) {
            $this->chartClass = $this->objectManager->get(GoogleChart::class);
        }
        $this->chartClass->setSettings($this->settings);

        $chartLibraryPath = $this->chartClass->getChartLibraryPath();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFile($chartLibraryPath);
    }

    /**
     * action show
     *
     * @param \Kennziffer\KeQuestionnaire\Domain\Model\Result $result A fresh new result object
     * @return void
     */
    public function showAction(\Kennziffer\KeQuestionnaire\Domain\Model\Result $result)
    {
        $this->chartClass->setResult($result);
        $this->chartClass->setRenderChart($this->settings['chart']['renderChart']);
        $this->chartClass->setChartType($this->settings['chart']['chartType']);
        $js = $this->chartClass->getHeaderJs();
        $GLOBALS['TSFE']->getPageRenderer()->addJsInlineCode('chartLibrary', $js);

        $this->view->assign('chart', $this->chartClass->getChartContainer());
    }
}
