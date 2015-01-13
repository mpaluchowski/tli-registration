var tliRegister = tliRegister || {};

tliRegister.auditLog = function() {

	var init = function() {
		initPaging();
	},

	initPaging = function() {
		$('#audit-log-load-btn').click(loadPage);
	},

	loadPage = function(e) {
		e.preventDefault();

		var table = $('#audit-log-table')
			currPage = table.data('page') ? table.data('page') : 1;

		$.ajaxQueue({
			url: table.attr('data-paging-url'),
			data: {
				page: currPage
			},
			success: function(data) {
				if (data) {
					$('tbody', table).append(data);
				} else {
					$('#audit-log-load-btn').fadeOut(function() {
						$(this).remove();
					});
				}
			},
			dataType: "html"
		});

		table.data('page', ++currPage);
	}

	return {
		init: init
	}

}();
