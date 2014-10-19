var tliRegister = tliRegister || {};

tliRegister.registrationForm = function() {

	var init = function() {
		initEmailExistingCheck();
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
	}

	return {
		init: init
	}

}();
