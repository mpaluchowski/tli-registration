var tliRegister = tliRegister || {};

tliRegister.registrationForm = function() {

	var init = function() {
		initCustomClubEntry();
		initDependentFieldGroups();
		initExclusiveChoices();
		initTotalPriceDisplay();
		initEmailExistingCheck();

		initExternalLinks();
	},

	/**
	 * Initialize handling for external links.
	 */
	initExternalLinks = function() {
		$('a[rel=external]').click(linkOpenNewWindow);
	},

	/**
	 * Open a link in a new window, preventing original page reload.
	 */
	linkOpenNewWindow = function(e) {
		e.preventDefault();
		window.open($(this).attr('href'));
	},

	initEmailExistingCheck = function() {
		$('#email')
			.keydown(
				$.proxy(
					cleanFieldFeedback,
					$("#email"),
					"#group-email",
					"#warning-email"
					)
				)
			.blur(handleEmailExistingCheck);
	},

	handleEmailExistingCheck = function(e) {
		if (!$(this).val() || $("#group-email").hasClass("has-warning"))
			return;

		$.ajaxQueue({
			url : '/registration/email_exists/' + $(this).val(),
			dataType : 'json',
			success : function(data) {
				if (undefined !== data.message) {
					displayFieldWarning("#group-email", "email", data.message);
				}
			}
			});
	},

	displayFieldWarning = function(fieldGroupSelector, fieldName, warningText) {
		$(fieldGroupSelector)
			.addClass("has-warning has-feedback")
			.append(
				$("<span>")
					.addClass("glyphicon glyphicon-warning-sign form-control-feedback")
				)
			.after(
				$("<div>")
					.attr("id", "warning-" + fieldName)
					.addClass("alert alert-warning")
					.attr("role", "alert")
					.html(warningText)
					.hide()
				);
		$("#warning-" + fieldName).slideDown();
	},

	cleanFieldFeedback = function(fieldGroupSelector, fieldAlertSelector) {
		$(fieldGroupSelector).removeClass("has-success has-warning has-error has-feedback");
		$("span.glyphicon", $(fieldGroupSelector)).remove();
		$(fieldAlertSelector).slideUp(function() { $(this).remove() });
	},

	initCustomClubEntry = function() {
		if ($("#home-club").val() !== "Other") {
			$("#home-club-custom").hide();
			$("#home-club-custom-help").hide();
		}
		$("#home-club").change(handleHomeClubSelection);
	},

	handleHomeClubSelection = function() {
		if ($(this).val() === "Other") {
			$("#home-club-custom-help:hidden").slideDown();
			$("#home-club-custom:hidden").slideDown()
				.prop("required", true);
		} else {
			$("#home-club-custom-help:visible").slideUp();
			$("#home-club-custom:visible").slideUp()
				.val("").prop("required", false);
		}
	},

	initDependentFieldGroups = function() {
		$('[data-depends-on]').each(function() {
			initDependentField(
				this,
				$(this).attr('data-depends-on'),
				$(this).attr('data-depends-on-value')
				);
		});
	},

	/**
	 * Initializes dependent fields, hiding them away until the dependency
	 * changes to the value indicating they should be shown.
	 *
	 * @param dependent Object with the dependent element.
	 * @param dependencyFieldName Selector for the dependency field.
	 * @param dependencyFieldValue Value of the dependency that triggers showing
	 * the dependents.
	 */
	initDependentField = function(dependent, dependencyFieldName, dependencyFieldValue) {
		var dependency = $(
			':input[name=' + dependencyFieldName + ']',
			$(dependent).closest('.form-group')
			);

		// Hide dependencies, unless dependent has the right value to display them
		if (!$(dependency).prop('checked')
					|| $(dependency).val() !== dependencyFieldValue) {
			$(dependent).hide();
		} else {
			// Add required status for dependent fields that need it
			$(':input', dependent).each(function() {
				$(this).prop('required', $(this).attr('data-required') === 'required');
			});
		}

		$(dependency).change(function(e) {
			if ($(this).prop('checked')
					&& $(this).val() === dependencyFieldValue
					&& !$(dependent).is(":visible")) {
				$(dependent).slideDown();
				$(':input', dependent).each(function() {
					$(this).prop('required', $(this).attr('data-required') === 'required');
				});
			} else if ($(dependent).is(":visible")) {
				$(dependent).slideUp(function() {
					$(':input', dependent)
						.prop('checked', false)
						.prop('required', false)
						.trigger('change');

					cleanFieldFeedback(
						$('.form-group', dependent),
						$('.help-block:last-child', dependent)
						);
				});
			}
		});
	},

	initExclusiveChoices = function() {
		$('[data-exclusive-with]').each(function() {
			initExclusiveField(
				this,
				$(this).attr('data-exclusive-with'),
				$(this).attr('data-exclusive-with-value')
				);
		})
	},

	initExclusiveField = function(field, exclusiveFieldName, exclusiveFieldValue) {
		var targetField = $('[name="' + exclusiveFieldName + '"]');

		$(targetField).change(function() {
			if ($(targetField).filter(':checked').map(function () {
						return this.value;
					}).get().indexOf(exclusiveFieldValue) > -1) {
				$(field)
					.prop('disabled', true)
					.prop('checked', false);
			} else {
				$(field).prop('disabled', false);
			}
		});
	},

	initTotalPriceDisplay = function() {
		// Initial recalculation with entrance fee
		recalculateTotalPrice();
		$('.field-price-affecting')
			.each(function() {
				$.proxy(togglePriceIndicator, $(this))();
			})
			.change(togglePriceIndicator)
			.change(recalculateTotalPrice);
	},

	togglePriceIndicator = function() {
		$(this).siblings('.label')
			.toggleClass('label-info', $(this).prop('checked'))
			.toggleClass('label-default', !$(this).prop('checked'));

		// Toggle labels on radio buttons thar were unchecked
		if ($(this).is(':radio')) {
			$('[name=' + $(this).attr('name') + ']')
				.not($(this))
				.each(function() {
					$(this).siblings('.label')
						.toggleClass('label-info', $(this).prop('checked'))
						.toggleClass('label-default', !$(this).prop('checked'));
					});
		}
	}

	recalculateTotalPrice = function() {
		$.ajaxQueue({
			url : "/registration/get_total_price",
			data : $("#registration-form").closest('form').serializeArray(),
			dataType : 'json',
			beforeSend : function() {
				$('#total-due').prepend('<i class="fa fa-refresh fa-spin">');
			},
			success : function(data) {
				$('#total-due').html($.map(data, function(obj) { return obj }).join(' / '));
			},
			error : function() {
				$('#total-due').html("&mdash;");
			}
		});
	}

	return {
		init: init
	}

}();
