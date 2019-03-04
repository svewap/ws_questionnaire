jQuery(window).load(function() {
	/*
	 * All divs with wsq-moveable should be made draggable
	 */
	jQuery( ".wsq-moveable" ).xdraggable();
	jQuery( ".wsq-moveable" ).xdraggable({
		revert: "invalid"
	});
	/*
	 * All divs with wsq-placeholder should be made droppable
	 */
	jQuery( ".wsq-placeholder" ).droppable({
		/* when one answer is dropped, the droppable should be disabled for other answers */
		drop: function (event, ui) {
			jQuery(this).droppable("option","accept","#"+ui.draggable.attr("id"));
			var hidden_name = "tx_wsquestionnaire_questionnaire[newResult][questions]["+jQuery(this).attr('question')+"][answers]["+jQuery(this).attr('answer')+"][value]";
			var hidden = jQuery(this).parent().find("input[name='"+hidden_name+"']");
			hidden.val(ui.draggable.html()).trigger('change');
		}
	});
	jQuery( ".wsqDDArea .wsq-placeholder" ).droppable({
		drop: function (event, ui) {
			var hidden_name = "tx_wsquestionnaire_questionnaire[newResult][questions]["+ui.draggable.attr('question')+"][answers]["+ui.draggable.attr('answer')+"][value]";
			var hidden = ui.draggable.find("input[name='"+hidden_name+"']");
			hidden.val(jQuery(this).attr('value')).trigger('change');
		}
	});
	/*
	 * Returner divs for moveable elements should be droppable too
	 */
	jQuery( ".wsq-moveable-container" ).droppable({
		/* when an answer is dragged back, the droppable should be reenabled for all */
		drop: function (event, ui){
			jQuery(this).parent().find(".wsq-placeholder").droppable("option","accept",".wsq-moveable");
			var hidden = jQuery(this).parent().find("input[value='"+ui.draggable.html()+"']");
			jQuery(hidden).val('').trigger('change');
		}
	});
	jQuery( ".wsqDDArea .wsq-moveable-container" ).droppable({
		drop: function (event, ui) {
			var hidden_name = "tx_wsquestionnaire_questionnaire[newResult][questions]["+ui.draggable.attr('question')+"][answers]["+ui.draggable.attr('answer')+"][value]";
			var hidden = ui.draggable.find("input[name='"+hidden_name+"']");
			hidden.val('').trigger('change');
		}
	});
	
	window.checkDDAnswers = function(){
		/*
		 * Checks the already given Cloze DD Answers
		 */
		jQuery.each(jQuery( ".wsqAnswerClozeTextDD .wsq-moveable-container > div" ), function(key, value){
			var term = jQuery(value).html();
			var hidden = jQuery(value).parent().parent().find("input[value='"+term+"']");
            if (jQuery(hidden).val()) {
				/* move the already answered to the answerbox */
				jQuery(hidden).parent().find(".wsq-placeholder").append(value);
			}
		});
        //newResult[questions][25][answers][36][value]
		jQuery.each(jQuery( ".wsqDDArea .wsq-moveable-container > div" ), function(key, value){
            var hidden_name = "tx_wsquestionnaire_questionnaire[newResult][questions]["+jQuery(value).attr('question')+"][answers]["+jQuery(value).attr('answer')+"][value]";
			var hidden = jQuery(value).find("input[name='"+hidden_name+"']");
            if (!jQuery(hidden).val()){
                var hidden_name = "newResult[questions]["+jQuery(value).attr('question')+"][answers]["+jQuery(value).attr('answer')+"][value]";
                var hidden = jQuery(value).find("input[name='"+hidden_name+"']");
            }
            /*
			* Checks the already given DD Image Answers
			*/
			if (jQuery(hidden).val()) {
                /* move the already answered to the answerbox */
				jQuery(hidden).parent().parent().parent().find(".wsq-placeholder.dd-area[value='"+jQuery(hidden).val()+"']").append(value);
				/* move the already answered to the answerbox */
				jQuery(hidden).parent().parent().parent().find(".wsq-placeholder.dd-sequence[value='"+jQuery(hidden).val()+"']").append(value);
			}
		});
	};
	checkDDAnswers();
});// end of file