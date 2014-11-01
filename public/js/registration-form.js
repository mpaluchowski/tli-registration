var tliRegister = tliRegister || {};

tliRegister.registrationForm = function() {

	var init = function() {
		initEmailExistingCheck();
		initCustomClubEntry();
		initDependentFieldGroups();
	},

	initEmailExistingCheck = function() {
		$('#email')
			.keydown(
				$.proxy(
					cleanFieldWarning,
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

		$.getJSON(
			'/registration/email_exists/' + $(this).val(),
			function(data, textStatus) {
				if (undefined !== data.message) {
					displayFieldWarning("#group-email", "email", data.message);
				}
			}
			);
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

	cleanFieldWarning = function(fieldGroupSelector, fieldWarningSelector) {
		if (!$(fieldGroupSelector).hasClass("has-warning"))
			return;

		$(fieldGroupSelector).removeClass("has-warning has-feedback");
		$("span.glyphicon", $(fieldGroupSelector)).remove();
		$(fieldWarningSelector).slideUp(function() { $(this).remove() });
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
					$(':input', dependent).prop('checked', false).prop('required', false);
				});
			}
		});
	}

	return {
		init: init
	}

}();
