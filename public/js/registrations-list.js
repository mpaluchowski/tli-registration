var tliRegister = tliRegister || {};

tliRegister.registrationsList = function() {

	var init = function() {
		initRegistrationDetailsExpander();
	},

	initRegistrationDetailsExpander = function() {
		$('.registration-details-expander').click(handleRegistrationExpansion);
	},

	handleRegistrationExpansion = function() {
		var row = $(this).closest('tr');
		var detailsRow = $('#details-' + row.attr('data-id'));

		if (detailsRow.length !== 0) {
			$('#details-' + row.attr('data-id')).toggle();
		} else {
			$.ajaxQueue({
				url : "/admin/get_registration_details",
				data : {
					id : row.attr('data-id')
				},
				dataType : "html",
				success : function(data) {
					var detailsRow = $('<tr><td colspan="6">')
						.attr('id', 'details-' + row.attr('data-id'))
						.insertAfter(row);
					$('td', detailsRow).html(data);
				}
			});
		}
		$('.fa', this).toggleClass('fa-plus-square').toggleClass('fa-minus-square');
	}

	return {
		init: init
	}

}();
