<?php

namespace Kennziffer\KeQuestionnaire\Evaluation;

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
class GoogleChart extends AbstractChart
{

    /**
     * this var will be used for template path generation
     *
     * @var string
     */
    protected $libraryName = 'GoogleChart';


    /**
     * add js libraries within HEAD-Tag
     *
     * @return string
     */
    public function getChartLibraryPath()
    {
        return 'https://www.google.com/jsapi';
    }

    /**
     * get JavaScript Array for Pie Charts
     *
     * @return string JsonEncoded JavaScript Array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getDataForPie()
    {
        switch ($this->getRenderChart()) {
            case RenderChartInterface::FINISHED:
                $amountOfFinishedResults = $this->resultRepository->findFinishedResults()->count();
                $amountOfNotFinishedResults = $this->resultRepository->findByFinished(0)->count();
                $dataChart = [
                    ['Title', 'Finished Questionnairs'],
                    ['Finished', $amountOfFinishedResults],
                    ['Not Finished', $amountOfNotFinishedResults]
                ];
                break;
        }

        return json_encode($dataChart);
    }

    /**
     * get JavaScript Array for Column Charts
     *
     * @return string JsonEncoded JavaScript Array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getDataForColumn()
    {
        switch ($this->getRenderChart()) {
            case RenderChartInterface::FINISHED:
                $amountOfFinishedResults = $this->resultRepository->findFinishedResults()->count();
                $amountOfNotFinishedResults = $this->resultRepository->findByFinished(0)->count();
                $dataChart = [
                    ['Title', 'Finished Questionnairs'],
                    ['Finished', $amountOfFinishedResults],
                    ['Not Finished', $amountOfNotFinishedResults]
                ];
                break;
            case RenderChartInterface::COMPARE_POINTS:
                $dataChart[] = [
                    'Title',
                    'Your own points',
                    'Average points of all participations'
                ];
                $results = $this->resultRepository->findAll();
                /* @var $userResultQuestion \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion */
                foreach ($this->result->getQuestions() as $userResultQuestion) {
                    $resultQuestions = $this->resultQuestionRepository->findByQuestion($userResultQuestion->getQuestion());
                    $sumPoints = 0;
                    /* @var $resultQuestion \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion */
                    foreach ($resultQuestions as $resultQuestion) {
                        $sumPoints += $resultQuestion->getPoints();
                    }
                    $dataChart[] = [
                        $resultQuestion->getQuestion()->getTitle(),
                        $userResultQuestion->getPoints(),
                        round($sumPoints / $resultQuestions->count())
                    ];
                }
                break;
        }

        return json_encode($dataChart);
    }

    /**
     * returns the HTML-Tag where the chart has to be displayed
     *
     * @return string
     */
    public function getChartContainer()
    {
        return $this->cObj->wrap($this->getContainerId(), '<div id="|"></div>');
    }

}
