$(function () {
	$('input[name="daterange"]').daterangepicker({
		locale: {
			format: "YYYY-MM-DD",
		},
		startDate: moment().startOf("month"),
		endDate: moment().endOf("month"),
	})
})
