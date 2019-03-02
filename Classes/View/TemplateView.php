<?php

namespace Kennziffer\KeQuestionnaire\View;

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
 *    Changes the TemplateView-Handling to allow that only some partials are present in the user defined partial-directory
 *
 * @package ke_questionnaire
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TemplateView extends \TYPO3\CMS\Fluid\View\TemplateView
{

    /**
     * Path to the partial root. If NULL, then $this->partialRootPathPattern will be used.
     * @var string
     */
    protected $basePartialRootPath = null;

    /**
     * Pattern to be resolved for "@partialRoot" in the other patterns.
     * @var string
     */
    protected $partialRootPathPattern = '@packageResourcesPath/Private/Partials';

    /**
     * Directory pattern for global partials. Not part of the public API, should not be changed for now.
     * @var string
     */
    private $partialPathAndFilenamePattern = '@partialRoot/@subpackage/@partial.@format';

    /**
     * Resolves the partial root to be used inside other paths.
     *
     * @return array Path(s) to partial root directory
     */
    public function getKeQPartialRootPaths()
    {
        if ($this->partialRootPaths !== null) {
            return $this->partialRootPaths;
        }
        /** @var $actionRequest \TYPO3\CMS\Extbase\Mvc\Request */
        $actionRequest = $this->controllerContext->getRequest();
        return [
            str_replace('@packageResourcesPath',
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($actionRequest->getControllerExtensionKey()) . 'Resources/',
                $this->partialRootPathPattern)
        ];
    }

    /**
     * Resolve the partial path and filename based on $this->partialPathAndFilenamePattern.
     *
     * @param string $partialName The name of the partial
     * @return string the full path which should be used. The path definitely exists.
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     */
    protected function getPartialPathAndFilename($partialName)
    {
        $paths = $this->expandGenericPathPattern($this->partialPathAndFilenamePattern, true, true);
        foreach ($paths as &$partialPathAndFilename) {
            $partialPathAndFilename = $this->resolveFileNamePath(str_replace('@partial', $partialName,
                $partialPathAndFilename));
            if (@file_exists($partialPathAndFilename)) {
                return $partialPathAndFilename;
            } else {
                $premiumPartialPathAndFilename = str_replace('ext/ke_questionnaire', 'ext/ke_questionnaire_premium',
                    $partialPathAndFilename);
                if (@file_exists($premiumPartialPathAndFilename)) {
                    return $premiumPartialPathAndFilename;
                }
            }
        }
        throw new \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException('The template files "' . implode('", "',
                $paths) . '" could not be loaded.', 1225709595);
    }

    /**
     * Resolves the partial root to be used inside other paths.
     *
     * @return array Path(s) to partial root directory
     */
    protected function getPartialRootPaths()
    {
        $base = 'EXT:ke_questionnaire/Resources/Private/Partials/';
        if ($this->partialRootPaths !== null) {
            if (!in_array($base, $this->partialRootPaths)) {
                $this->partialRootPaths[] = $base;
            }
            return $this->partialRootPaths;
        }
        /** @var $actionRequest \TYPO3\CMS\Extbase\Mvc\Request */
        $actionRequest = $this->controllerContext->getRequest();
        return [
            str_replace('@packageResourcesPath',
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($actionRequest->getControllerExtensionKey()) . 'Resources/',
                $this->partialRootPathPattern)
        ];
    }


}
