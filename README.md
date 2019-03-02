**Fork for TYPO3 8 LTS**

This is NOT the offical Version of ke_questionnaire!
=======================================================
I just made a fork and made changes, that enables the USE of TYPO3 8-LTS as i needed this in 2 projects.

================================================

Things i have done:
- Moved all needed Code from ext_tables to Configuration\TCA 
- Needed changes in TCA (lll references, richtext and Field config changes like sys_language_uid)
- added TCA\Overrrides\tt_content.php and sys_template.php

- should be still compatible with premium Version of ke_questionnaire (if there is a 8 TLS version), but i did not test this.
- Not tested with older Versions of TYPO3
- Not tested dependencies and ranges as not used in my projects
- Fixed a bug in Export-as-csv file, to allow excel to open the file directly instead of need to open file in Excel as TXT File, select charset etc.

- moved settings.showAvarage to access tab because in layout tab the display conditions does not work as with settings.accessType

## Added new features: 
Maybe also it would be possible to use hooks/signalslot to receice this, i decide to integrate my features directly, as it looks as there will be no further developement of ke_questionnaire.
The added features are:
- Choose X Random Questions from question pool and max random questions per page
- max. time in seconds for total questionnaire
- Possability in extension configuration to disable in backendcotroller, that the list of feusers, feGroups or tt Addresses are loaded
 (will run into memory problem in Installations with lots of fe users, groups or tt_addresses)


I also changed configuration\flexforms\questionnaire.xlm to be able to configure this 2 new features.
if you have your own flexform, you need to copy this 3 new fields to your flexform.



## TODO-List:

Maybe we need also to adjust file view/chart.php
it uses:
- TYPO3\CMS\Fluid\View\TemplateView->getLayoutRootPath() 
since fluid 8.7 is removed. Need to use getLayoutRootPaths()

## Breaking changes

If you have changed the template:
ke_questionnaire/Resources/Private/Templates/Backend/AuthCodesMail.html
or the partial:
ke_questionnaire/Resources/Private/Partials/Backend/CreateAndMailAuthCodes.html

you need to adjust this:
(You need to handover to the partial parameter 'text' and render the Email preview inside of the template )

## Bugs / Issues
feel free to report Bugs to my fork in the github issue list.
or create directly a pull request. 

[Github Repo](https://github.com/jvelletti/ke_qeustionnaire/issues)

## Contact
- Email: typo3@velletti.de
- Web: https://www.velletti.de
- twitter: #tangomuc
- slack: @jvelletti