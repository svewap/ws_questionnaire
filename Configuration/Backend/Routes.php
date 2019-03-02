<?php
/**
 * Definitions for routes provided by EXT:ws_questionnaire
 * Contains all "regular" routes for entry points
 */
return [
    /** Wizards */
    // Register backend_layout wizard
    'wizard_imageAreaSelect' => [
        'path' => '/wizard/imageAreaSelect',
        'target' => WapplerSystems\WsQuestionnaire\Controller\Wizard\ImageAreaSelectController::class . '::mainAction'
    ] 
];
