// When ready :)
jQuery(document).ready(function() {
	
	function addItem(evt) {

        let count = jQuery(".cnrc-form-item").length;
        count++;

        let itemId = "cnrc-form-item-" + count;
        
        let currentItem = jQuery(this).closest(".cnrc-form-item")

        let clonedItem = currentItem.clone();
        clonedItem.attr("id",itemId);
        currentItem.find(".cnrc-item-quantity input").val = null;
		currentItem.find(".cnrc-item-add").remove();
        currentItem.after(clonedItem);

        jQuery("#" + itemId + " .cnrc-item-add").on("click", addItem);
        jQuery("#" + itemId + " .cnrc-item-type select, #" + itemId + " .cnrc-item-quantity input").change("click", calculateCNRatio);

    }

	jQuery(".cnrc-item-add").on("click", addItem);

	jQuery(".cnrc-unit").change("click", function(evt) {
		let text = jQuery('option:selected', this).attr('value')
		jQuery(".cnrc-form-item .cnrc-item-quantity label").text(text);
	});

	function calculateCNRatio() {
		let totalQuantity = 0;
		let totalCarbon = 0;
		let items = jQuery(".cnrc-form-item");
		let countItems = items.length;

		jQuery(items).each(function( index ) {
			let carbon = jQuery(this).find(".cnrc-item-type select option:selected").attr('value');
			let quantity = parseFloat(jQuery(this).find(".cnrc-item-quantity input").val());
			totalCarbon += carbon * quantity;
			totalQuantity += quantity;
		});

		if (totalQuantity > 0) {
			let result = totalCarbon/totalQuantity;
			if (isNaN(result)) {
				jQuery("#cnrc-result-carbon").text("?");	
			} else {
				jQuery("#cnrc-result-carbon").text(parseInt(result));
			}
		} else {
			jQuery("#cnrc-result-carbon").text("?");
		}
	}
	
	jQuery(".cnrc-unit, .cnrc-form-item .cnrc-item-type select, .cnrc-form-item .cnrc-item-quantity input").change("click", calculateCNRatio);

});