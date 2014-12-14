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
					$('.has-error', row).each(function() {
						$(this).children('.help-block').slideUp(function() {
							$(this).remove();
						});
						$(this).removeClass('has-error');
					});
				}
			});
	}

	return {
		init: init
	}

}();
