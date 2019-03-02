<?php

namespace Kennziffer\KeQuestionnaire\Utility;

use Kennziffer\KeQuestionnaire\Domain\Model\Question;

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
class JqPlot
{
    /**
     * getChart
     *
     * @param string $type
     * @param array $dataArray
     * @param string $divId
     * @param Question $question
     * @param array $labels
     * @return string
     */
    public function getChart(
        $type,
        $divId,
        $dataArray,
        Question $question = null,
        $labels = null
    ) {
        switch ($type) {
            case 'lines':
                return $this->createLineChart($divId, $dataArray);
                break;
            case 'barChart':
                return $this->createSingleBarChart($divId, $dataArray, $question, $labels);
                break;
            case 'pieChart':
            default:
                return $this->createPieChart($divId, $dataArray, $question);
                break;

        }
    }

    /**
     * create line
     *
     * @param $divId
     * @param array $dataArray
     * @return string
     */
    public function createLineChart($divId, $dataArray)
    {
        $lines = [];
        $line_names = '';
        foreach ($dataArray as $type => $values) {
            $line_names .= 'line_' . $type . ',';
            $lines[$type]['title'] = $values['title'];
            if (is_array($values['dates'])) {
                foreach ($values['dates'] as $date => $amount) {
                    $lines[$type]['data'] .= "['" . $date . "'," . $amount . "],";
                }
            }
            $lines[$type]['data'] = '[' . rtrim($lines[$type]['data'], ',') . ']';
        }
        $line_names = '[' . rtrim($line_names, ',') . ']';

        //$js = "jQuery(document).ready(function(){\n";
        $js = '';
        foreach ($lines as $type => $line) {
            if ($line['data'] == '[]') {
                $line['data'] = "['']";
            }
            $js .= "			var line_" . $type . " = " . $line['data'] . ";\n";
        }
        //Evtl verbesserung: bei einer Anzahl von Teilnahmen < 10 => y-axis mit min value/tick interval etc.
        //Bei < 5 Tagen => x-axis mit tickInterval 1day
        $js .= "var linePlot = jQuery.jqplot ('" . $divId . "', " . $line_names . ",
		          {
						axesDefaults: {
							autoscale: true,
							tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer ,
							tickOptions: {
								fontFamily: 'Georgia',
								angle: 65,
								fontSize: '10pt'
							},
							pad: 2							
						},							
						axes:{
							xaxis:{
								renderer: jQuery.jqplot.DateAxisRenderer,
								tickOptions: {formatString:'%#d. %b %y'}
							},
							yaxis:{
								tickOptions: {formatString: '%#d'},
								tickInterval: 1,								
								padMin: 0
							}
						},
						series:[";
        foreach ($lines as $type => $line) {
            $js .= "				{
										label: '" . $line['title'] . "',
										lineWidth: 3, 
										markerOptions: {style:'square'}
									},
					";
        }

        $js .= "		],
						legend: { 
							show:true, 
							location: 'e',
							fontSize: '10px',
							border: 'none'
						},
						cursor:{
							show: true,
							zoom:true,
							showTooltip: false,
							clickReset: true
						},
						highlighter:{
							show: true
						}
                  }
                );";
        //   });";
        return $js;
    }

    /**
     * create bar
     *
     * @param string $type
     * @param array $values
     * @param Question $question
     * @param bool $labels
     * @return string $chart
     */
    public function createSingleBarChart(
        $type,
        $values,
        Question $question,
        $labels = false
    ) {
        if (is_array($values)) {
            ksort($values);
            $counter = 0;
            foreach ($values as $nr => $bar) {
                if ($bar['value'] > $counter) {
                    $counter = $bar['value'];
                }
                $singleBar .= $bar['value'] . ',';
                if ($labels[$nr]) {
                    $ticks .= "'" . $labels[$nr] . "',";
                } else {
                    $ticks .= "'" . $nr . "',";
                }
                $label_c++;
            }
            $singleBar = rtrim($singleBar, ',');
            $ticks = rtrim($ticks, ',');
            $counter += 2;

            $js =
                "
					var bar = [" . $singleBar . "];
					var ticks = [" . $ticks . "];
					var plot1 = jQuery.jqplot ('chart_" . $type . "_" . $question->getUid() . "', [bar], 
						{
							seriesDefaults: {
								renderer: jQuery.jqplot.BarRenderer,
								rendererOptions: {
									fillToZero: true,
									barMargin: 20,
								},
								pointLabels: {
									show: true, 
									location: 'n', 
									edgeTolerance: -15, 
									hideZeros: true
								}
							},
							axesDefaults: {
								tickOptions: {								
									fontSize: '10pt'
								},
								pad: 2							
							},		
							axes: {
								xaxis: {
									renderer: jQuery.jqplot.CategoryAxisRenderer,
									ticks: ticks
								},
								yaxis: {
									tickOptions: {formatString: '%#d'},								
								}
							}
						}
					);
				";
        }
        return $js;
    }

    /**
     * create pie
     *
     * @param string $type
     * @param array $values
     * @param Question $question
     * @param bool $absoluteValues
     * @return string $chart
     */
    public function createPieChart(
        $type,
        $values,
        Question $question = null,
        $absoluteValues = false
    ) {
        $data = '[';
        foreach ($values as $key => $answer) {
            if ($answer['answer']) {
                $data .= "['" . $answer['answer']->getTitle() . "', ";
            } else {
                $data .= "['" . $key . "', ";
            }
            $data .= $answer["value"] . "],";
        }
        $data = rtrim($data, ',');
        $data .= ']';
        $js = //"jQuery(document).ready(function(){
            "
                var data = " . $data . ";";
        if ($question) {
            $js .= "var plot1 = jQuery.jqplot ('chart_" . $type . "_" . $question->getUid() . "', [data],";
        } else {
            $js .= "var plot1 = jQuery.jqplot ('chart_" . $type . "', [data],";
        }
        $js .= "
                  {
                    seriesDefaults: {
                      // Make this a pie chart.
                      renderer: jQuery.jqplot.PieRenderer,
                      rendererOptions: {
                        // Put data labels on the pie slices.
                        // By default, labels show the percentage of the slice.
                        showDataLabels: true";
        if ($absoluteValues) {
            $js .= "		, \n dataLabels: 'value'\n";
        }
        $js .= "  }
                    },
                    legend: { 
						show:true, 
						location: 'e',
						fontSize: '10px',
						border: 'none'
					}
                  }
                );";
        //});";
        return $js;
    }
}

