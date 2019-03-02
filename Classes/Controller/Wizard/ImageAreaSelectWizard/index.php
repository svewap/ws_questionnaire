<?php
// Deprecated since 7.6, needed for 6.2, will be removed with 8
namespace Kennziffer\KeQuestionnaire\Controller\Wizard\ImageAreaSelectWizard;

/**
 * Image Area Select Wizard
 */
class ImageAreaSelectWizard
{

    /**
     * Initialises the Class
     *
     * @return    void
     */
    function init()
    {
        // Setting GET vars (used in frameset script):
        $this->P = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('P');

        // Setting GET vars (used in colorpicker script):
        $this->currentValue = $this->P['currentValue'];
        $this->fieldChangeFunc = $this->P['fieldChangeFunc'];
        $this->fieldChangeFuncHash = $this->P['fieldChangeFuncHash'];
        $this->itemName = $this->P['itemName'];
        $this->formName = $this->P['formName'];
        $this->md5ID = $this->P['md5ID'];

        $this->uid = $this->P['uid'];
    }

    /**
     * Dispatch on action
     *
     * Calls the requested action
     *
     * @return void
     */
    public function dispatch()
    {
        $this->init();
        $this->indexAction();
    }

    /**
     * The index action
     *
     * The action which should be taken when the wizard is loaded
     *
     * @return void
     */
    protected function indexAction()
    {
        /** @var $view tx_form_View_Wizard_Wizard */
        $view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Kennziffer\KeQuestionnaire\View\ImageAreaSelectWizard::class);
        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ke_questionnaire');
        $path = 'Resources/Private/Templates/Wizards/ImageAreaSelect.html';
        $view->setTemplatePathAndFilename($extPath . $path);
        $view->setLayoutRootPath($extPath . 'Resources/Private/Layouts');

        $answer = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($this->P['table'], $this->P['uid']);
        $view->assign('answer', $answer);
        $view->assign('baseUri', $view->getRequest()->getBaseUri());
        $view->assign('P', $this->P);

        echo $view->render();
    }
}

$wizard = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Kennziffer\KeQuestionnaire\Controller\Wizard\ImageAreaSelectWizard\ImageAreaSelectWizard::class);
$wizard->dispatch();