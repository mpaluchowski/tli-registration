var tliRegister = tliRegister || {};

tliRegister.registrationsList = function() {

	var init = function() {
		initRegistrationDetailsExpander();
		initStatusChanger();
	},

	initRegistrationDetailsExpander = function() {
		$('.registration-details-expander').click(handleRegistrationExpansion);
	},

	handleRegistrationExpansion = function(e) {
		e.preventDefault();

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
	},

	initStatusChanger = function() {
		$('.tli-status-changer').click(openStatusChangeMenu);
	},

	openStatusChangeMenu = function() {
		var label = $(this),
			menu = $('#tli-status-menu').clone().removeAttr('id');
		$('input[value=' + label.attr('data-value') + ']', menu).prop('checked', true);
		$('input[name=id]', menu).val($(label).closest('tr').attr('data-id'));
		$('button[type=reset]', menu).click(function() {
			$(menu).fadeOut(100, function() {
				$(menu).remove();
			})
		});
		label.after(menu);
	}

	return {
		init: init
	}

}();
