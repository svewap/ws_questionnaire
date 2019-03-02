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
class Flotr2Chart extends AbstractChart
{

    /**
     * this var will be used for template path generation
     *
     * @var string
     */
    protected $libraryName = 'Flotr2Chart';


    /**
     * add js libraries within HEAD-Tag
     *
     * @return void
     */
    public function getChartLibraryPath()
    {
        return '';
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
                    [
                        'data' => [
                            [0, $amountOfFinishedResults]
                        ],
                        'label' => 'Finished'
                    ],
                    [
                        'data' => [
                            [0, $amountOfNotFinishedResults]
                        ],
                        'label' => 'Not finished'
                    ],
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
                    [
                        'data' => [
                            [1, $amountOfFinishedResults]
                        ],
                        'label' => 'Finished'
                    ],
                    [
                        'data' => [
                            [2, $amountOfNotFinishedResults]
                        ],
                        'label' => 'Not finished'
                    ],
                ];
                break;
            case RenderChartInterface::COMPARE_POINTS:
                $results = $this->resultRepository->findAll();
                $counter = 1;
                /* @var $userResultQuestion \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion */
                foreach ($this->result->getQuestions() as $userResultQuestion) {
                    $resultQuestions = $this->resultQuestionRepository->findByQuestion($userResultQuestion->getQuestion());
                    $sumPoints = 0;
                    /* @var $resultQuestion \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion */
                    foreach ($resultQuestions as $resultQuestion) {
                        $sumPoints += $resultQuestion->getPoints();
                    }
                    $col1[] = [
                        $counter,
                        $userResultQuestion->getPoints()
                    ];
                    $col2[] = [
                        $counter + 0.5,
                        round($sumPoints / $resultQuestions->count())
                    ];
                    $counter++;
                }
                $dataChart[] = [
                    'data' => $col1,
                    'label' => 'Your own points'
                ];
                $dataChart[] = [
                    'data' => $col2,
                    'label' => 'Average point of all participations'
                ];
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
        return '<div id="' . $this->getContainerId() . '" style="height: 300px; width: 400px;"></div>';
    }
}
