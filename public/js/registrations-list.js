var tliRegister = tliRegister || {};

tliRegister.registrationsList = function() {

	var init = function() {
		initRegistrationDetailsExpander();
	},

	initRegistrationDetailsExpander = function() {
		$('.registration-details-expander').click(handleRegistrationExpansion);
	},

	handleRegistrationExpansion = function() {
		console.log($(this).closest('tr').attr('data-id'));
	}

	return {
		init: init
	}

}();
