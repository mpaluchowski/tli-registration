var tliRegister = tliRegister || {};

tliRegister.discountCodes = function() {

	var init = function() {
		initCodeItemEnabling();
	},

	initCodeItemEnabling = function() {
		$('#discount-code-items input:checkbox')
			.change(handlePricingItemChange)
			.each(handlePricingItemChange);
	},

	handlePricingItemChange = function() {
		var row = $(this).closest('tr'),
			chekbox = this;

		$('input[type=number]', row)
			.prop('disabled', !$(chekbox).prop('checked'))
			.each(function() {
				if (!$(chekbox).prop('checked')) {
					$(this).val($(this).attr('data-value-original'));
				}
			});
	}

	return {
		init: init
	}

}();
