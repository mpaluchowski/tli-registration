var tliRegister = tliRegister || {};

tliRegister.discountCodes = function() {

	var init = function() {
		initCodeItemEnabling();
	},

	initCodeItemEnabling = function() {
		$('#discount-code-items input:checkbox').change(handlePricingItemChange);
	},

	handlePricingItemChange = function(e) {
		var row = $(this).closest('tr');

		$('input[type=number]', row)
			.prop('disabled', !$(this).prop('checked'))
			.each(function() {
				$(this).val($(this).attr('data-value-original'));
			});
	}

	return {
		init: init
	}

}();
