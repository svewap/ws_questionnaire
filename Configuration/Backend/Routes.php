<?php
/**
 * Definitions for routes provided by EXT:ke_questionnaire
 * Contains all "regular" routes for entry points
 */
return [
    /** Wizards */
    // Register backend_layout wizard
    'wizard_imageAreaSelect' => [
        'path' => '/wizard/imageAreaSelect',
        'target' => Kennziffer\KeQuestionnaire\Controller\Wizard\ImageAreaSelectController::class . '::mainAction'
    ] 
];
