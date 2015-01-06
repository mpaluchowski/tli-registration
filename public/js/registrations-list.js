var tliRegister = tliRegister || {};

tliRegister.registrationsList = function() {

	var _msgTimeout,

	init = function() {
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
			menu = $('#tli-status-menu').clone().removeAttr('id'),
			form = $('form', menu);
			original = $('input[value=' + label.attr('data-value') + ']', menu),
			alert = $('.alert', menu);

		// Setup form fields
		original.prop('checked', true);
		$('input[name=id]', menu).val($(label).closest('tr').attr('data-id'));
		$('button[type=reset]', menu).click(function() {
			$(menu).fadeOut(100, function() {
				$(menu).remove();
			})
		});
		// Show the switch menu
		label.after(menu);

		// Show warning when choosing away from certain options
		$('input[name=status]', menu).change(function() {
			if (original.attr('data-select-away-msg')
				&& $(this).val() !== original.val()) {
				// Show warning
				alert.html(original.attr('data-select-away-msg')).slideDown();
			} else {
				// Hide warning
				alert.slideUp();
			}
		});

		// Form submit via AJAX
		form.submit(function() {
			$.post(
				form.attr('action'),
				form.serialize(),
				function(data) {
					label
						.attr('class', 'label label-' + data.label.class)
						.html(data.label.text);
					displayHoveringMessage(data.msg);
				},
				'json'
				);
			return false;
		});
	},

	/**
	 * Displays a hovering message over the page. Will add a close button to
	 * it and have it close automatically after a period of time.
	 *
	 * @param msg The message object to diplay.
	 */
	displayHoveringMessage = function(msg) {
		var message = $(msg).addClass('alert-dismissible')
			.prepend('<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'),
			container = $('#tli-message-hover');
		if (!container.length)
			container = $('<div id="tli-message-hover">').insertAfter($('.page-header:first'));

		container.html(message).show();

		clearTimeout(_msgTimeout);
		_msgTimeout = setTimeout(function () {
			container.fadeOut();
		}, 5000);
	}

	return {
		init: init
	}

}();
