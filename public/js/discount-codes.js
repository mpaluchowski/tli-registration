var tliRegister = tliRegister || {};

tliRegister.discountCodes = function() {

	var init = function() {
		initCodeCreatePanel();
		initCodeItemEnabling();
		initCreateButtonLabel();
	},

	initCodeCreatePanel = function() {
		if (!$('#create-code-panel').attr('data-visible')) {
			$('#create-code-panel').hide();
			$('#create-code-button')
				.show()
				.click(openCodeCreatePanel);
		}
	},

	openCodeCreatePanel = function() {
		$('#create-code-panel').slideDown(function() {
			$('[autofocus]', $(this)).focus();
			$('#create-code-button').hide();
		});
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
			.prop('required', $(chekbox).prop('checked'))
			.each(function() {
				if (!$(chekbox).prop('checked')) {
					$(this).val('');
					$('.has-error', row).each(function() {
						$(this).children('.help-block').slideUp(function() {
							$(this).remove();
						});
						$(this).removeClass('has-error');
					});
				}
			});
	},

	initCreateButtonLabel = function() {
		$('#send-email')
			.change(switchButtonLabel)
			.change(toggleEmailLanguage);
	},

	switchButtonLabel = function() {
		if ($(this).prop('checked')) {
			$('#create-code-btn').html(
				$('#create-code-btn').attr('data-email-label')
				);
		} else {
			$('#create-code-btn').html(
				$('#create-code-btn').attr('data-create-label')
				);
		}
	},

	toggleEmailLanguage = function() {
		$('#send-email-language').prop('disabled', !$(this).prop('checked'));
	}

	return {
		init: init
	}

}();
