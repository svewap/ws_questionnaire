<?php

namespace Kennziffer\KeQuestionnaire\ViewHelpers;

use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDAreaImage;
use Kennziffer\KeQuestionnaire\Domain\Model\AnswerType\DDImage;
use Kennziffer\KeQuestionnaire\Domain\Model\QuestionType\Question;
use Kennziffer\KeQuestionnaire\Domain\Model\Result;
use Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer;

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
 * ViewHelper for the image in pdf-export of ddarea-image
 * creates an image-file with the drag-images positioned inside the areas
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DdAreaExportViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
     * @param DDAreaImage $answer Answer to be rendered
     * @param Question $question the images are in
     * @param Result $result
     * @param string $as The name of the iteration variable
     * @return string filename
     */
    public function render(
        DDAreaImage $answer,
        Question $question,
        Result $result,
        $as
    ) {
        //area image
        $main = $answer->getImage();
        //d&d images
        $images = $this->getImages($question, $answer);

        $templateVariableContainer = $this->renderingContext->getVariableProvider();
        if ($question === null) {
            return '';
        }

        //create the temp-image
        $image = $this->createExportImage($main, $images, $result, $question, $answer);
        //image to be rendered => $as should be the filename in the typo3temp/ke_questionnaire folder
        $templateVariableContainer->add($as, $image);
        $output = $this->renderChildren();
        $templateVariableContainer->remove($as);
        return $output;
    }

    /**
     * Create the output-image
     *
     * @param string $main main-image
     * @param array $images d&d images
     * @param Result $result
     * @param Question $question the images are in
     * @param DDAreaImage $answer Answer to be rendered
     * @return string
     */
    private function createExportImage(
        $main,
        array $images,
        Result $result,
        Question $question,
        DDAreaImage $answer
    ) {
        $filename = 'test.png';
        $main_infos = [];

        //get image size of main image
        $size = getimagesize(PATH_site . 'uploads/tx_kequestionnaire/' . $main, $main_infos);
        $mainImage = null;
        switch ($size[2]) {
            case 1: //IMAGETYPE_GIF
                $mainImage = imagecreatefromgif(PATH_site . 'uploads/tx_kequestionnaire/' . $main);
                break;
            case 2: //IMAGETYPE_JPEG
                $mainImage = imagecreatefromjpeg(PATH_site . 'uploads/tx_kequestionnaire/' . $main);
                break;
            case 3: //IMAGETYPE_PNG
                $mainImage = imagecreatefrompng(PATH_site . 'uploads/tx_kequestionnaire/' . $main);
                break;
        }
        if (!$mainImage) {
            return '';
        }
        $areas = $answer->getCoords();
        $ddImage = null;
        foreach ($images as $image) {
            $resultAnswer = $this->getResultAnswer($result, $question->getUid(), $image->getUid());
            $info = getimagesize(PATH_site . 'uploads/tx_kequestionnaire/' . $image->getImage());
            switch ($info[2]) {
                case 1: //IMAGETYPE_GIF
                    $ddImage = imagecreatefromgif(PATH_site . 'uploads/tx_kequestionnaire/' . $image->getImage());
                    break;
                case 2: //IMAGETYPE_JPEG
                    $ddImage = imagecreatefromjpeg(PATH_site . 'uploads/tx_kequestionnaire/' . $image->getImage());
                    break;
                case 3: //IMAGETYPE_PNG
                    $ddImage = imagecreatefrompng(PATH_site . 'uploads/tx_kequestionnaire/' . $image->getImage());
                    break;
            }
            if ($resultAnswer !== null && $resultAnswer->getValue() && $ddImage) {
                $x = 0;
                $y = 0;
                $area_coords = [];
                foreach ($areas as $aid => $area) {
                    if ($area['key'] == $resultAnswer->getValue()) {
                        $area['base_key'] = $aid;
                        $area_coords = $area;
                    }
                }
                if ($area_coords['amount'] > 0) {
                    $x = $area_coords['left'] + $image->getWidth() + 2;
                    $y = $area_coords['y1'];
                    if (($x + $image->getWidth()) > $area_coords['x2']) {
                        $x = $area_coords['x1'];
                        $y = $area_coords['top'] + $image->getHeight() + 2;
                    }
                } else {
                    $x = $area_coords['x1'];
                    $y = $area_coords['y1'];
                }
                $areas[$area_coords['base_key']]['amount']++;
                $areas[$area_coords['base_key']]['left'] = $x;
                $areas[$area_coords['base_key']]['top'] = $y;
                if ($image->getWidth() || $image->getHeight()) {
                    $newWidth = $image->getWidth();
                    $newHeight = $image->getHeight();
                    imagecopyresized($mainImage, $ddImage, $x, $y, 0, 0, $newWidth, $newHeight, $info[0], $info[1]);
                } else {
                    imagecopy($mainImage, $ddImage, $x, $y, 0, 0, $info[0], $info[1]);
                }
            }
            imagedestroy($ddImage);
        }

        $save_file = PATH_site . 'typo3temp/ke_questionnaire/' . $filename;
        imagepng($mainImage, $save_file);
        imagedestroy($mainImage);

        return $filename;
    }

    /**
     * Returns a requested question from result record
     *
     * @param Result $result
     * @param int $questionUid
     * @param int $answerUid
     * @return null|ResultAnswer
     */
    public function getResultAnswer($result, $questionUid, $answerUid)
    {
        $resultQuestions = $result->getQuestions();
        /* @var $resultQuestion \Kennziffer\KeQuestionnaire\Domain\Model\ResultQuestion */
        foreach ($resultQuestions as $resultQuestion) {
            if ($resultQuestion->getQuestion() && $questionUid === $resultQuestion->getQuestion()->getUid()) {
                /* @var $resultAnswer \Kennziffer\KeQuestionnaire\Domain\Model\ResultAnswer */
                foreach ($resultQuestion->getAnswers()->toArray() as $resultAnswer) {
                    if ($resultAnswer->getAnswer() && $answerUid === $resultAnswer->getAnswer()->getUid()) {
                        return $resultAnswer;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Gets the Images
     *
     * @param Question $question the terms are in
     * @param $header
     * @return array
     */
    public function getImages($question, $header)
    {
        $terms = [];

        // workaround for pointer in question, so all following answer-objects are rendered.
        $addIt = false;
        $answers = $question->getAnswers();

        foreach ($answers as $answer) {
            //Add only after the correct Header is found, only following rows will be added.
            if ($answer instanceof DDAreaImage) {
                $addIt = false;
                if ($answer === $header) {
                    $addIt = true;
                }
            }
            if ($addIt) {
                if ($answer instanceof DDImage) {
                    $terms[] = $answer;
                }
            }
        }

        return $terms;
    }
}
