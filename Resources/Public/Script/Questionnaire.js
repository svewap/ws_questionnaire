location.hash = '#no-';
if (location.hash == '#no-') {
    location.hash = '#_';
    window.onhashchange = function () {
        if (location.hash == '#no-')
            location.hash = '#_';
    }
}

jQuery(document).ready(function () {

    var $loading = $('#wsq_loadingDiv').hide();
    jQuery(document)
        .ajaxStart(function () {
            $loading.show();
        })
        .ajaxStop(function () {
            $loading.hide();
        });

    jQuery(".wsqButtons input.prev").on("click", function () {
        $currentPage = jQuery(".tx-ws-questionnaire input.currentPage").val();
        jQuery(".tx-ws-questionnaire input.requestedPage").val($currentPage - 1);
        jQuery(".tx-ws-questionnaire form").submit();
    });

    /*
     * Submit the Form to a defined page
     */
    window.submitToPage = function ($page) {
        jQuery(".tx-ws-questionnaire input.requestedPage").val($page);
        jQuery(".tx-ws-questionnaire form").submit();
    }

    /*
     * Check if there are Answer-Errors on the Questionnaire-Page
     * If there are Errors, supress the submit buttons
     */
    window.checkAnswerErrors = function () {
        if (jQuery("input[id^='wsqAnswerError']").filter("input[value='1']").length == 0) {
            jQuery("input[type='submit']").removeAttr("disabled");
            return true;
        } else {
            jQuery("input[type='submit']").attr("disabled", "disabled");
            return false;
        }
    };

    /*
     * Check if there are Mandatory Questions
     */
    window.checkMandatory = function () {
        if (jQuery("input[id^='wsqMandatory']").filter(function () {
            if (jQuery(this).parent().parent().is(":hidden")) return false;
            if (jQuery(this).val() == 1) return true;
        }).length == 0) {
            return true;
        }
        return false;
    };

    /*
     * Check Mandatory when submitting
     */
    window.checkMandatorySubmit = function () {
        var isCorrect = true;
        jQuery("input[id^='wsqMandatory']").each(function (index) {
            if (jQuery(this).prop("value") == "1") {
                if (jQuery(this).parent().parent().is(":hidden")) {
                } else {
                    jQuery(this).parent().fadeIn();
                    isCorrect = false;
                }
            } else {
                jQuery(this).parent().fadeOut();
            }
        });

        return isCorrect;
    };

    /*
     * Check if the Form is Valid and should be submitted
     * If there are AnswerErrors or not answered mandatory questions, it returns false
     */
    window.wsqFormIsValid = function () {
        //ToDo: Validate all questions on the page
        if (checkAnswerErrors() == true && checkMandatory() == true) return true;
        else return false;
    };

    /*
     * Checks on submit if the Questionnaire Page is valid and should be allowed to be submitted
     */
    jQuery(".tx-ws-questionnaire form").on("submit", function () {
        if (!checkMandatorySubmit()) {
            return false;
        }

        if (!wsqFormIsValid()) {
            return false;
        }
    });

    checkAnswerErrors();
    checkMandatory();

    /* TODO: Relcate to DD-JS-File when preloader is ready */

    /*
     * Check the Radio Buttons with input fields
     */
    window.checkMatrixRadioValues = function (idy) {
        jQuery.each(jQuery("#" + idy + " input:radio"), function () {
            if (jQuery(this).prop('checked')) {
                jQuery(this).parent().children('input:text').removeProp('disabled');
            } else {
                jQuery(this).parent().children('input:text').val('');
                jQuery(this).parent().children('input:text').prop('disabled', 'disabled');
            }
        });
    };
    /*
     * Check the Checkboxes with input fields
     */
    window.checkMatrixCheckboxValues = function (check) {
        if (jQuery(check).prop('checked')) {
            jQuery(check).parent().children('input:text').removeProp('disabled');
        } else {
            jQuery(check).parent().children('input:text').val('');
            jQuery(check).parent().children('input:text').prop('disabled', 'disabled');
        }
    };

    /*
     * Clone a Matrix Row
     */
    jQuery(".wsqMatrixAddClone").on("click", function () {
        counter = jQuery(this).parent().parent().siblings().length + 10;
        $row = jQuery(this).parent().parent().siblings(".wsqClonableRow").clone().removeClass('wsqClonableRow');
        $inputs = $row.find('input');
        $inputs.each(function (index) {
            jQuery(this).attr('name', jQuery(this).attr('name').replace('1000', counter));
            if (jQuery(this).attr('id')) jQuery(this).attr('id', jQuery(this).attr('id').replace('clone1000', 'clone' + counter));
        });
        $inputs = $row.find('select');
        $inputs.each(function (index) {
            jQuery(this).attr('name', jQuery(this).attr('name').replace('1000', counter));
            if (jQuery(this).attr('id')) jQuery(this).attr('id', jQuery(this).attr('id').replace('clone1000', 'clone' + counter));
        });
        $labels = $row.find('label');
        $labels.each(function (index) {
            jQuery(this).attr('for', jQuery(this).attr('for').replace('clone1000', 'clone' + counter));
        });
        $row.insertBefore(jQuery(this).parent().parent().siblings(".wsqClonableRow"));
    });
});