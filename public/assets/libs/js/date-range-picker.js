$(function () {
	$('input[name="daterange"]').daterangepicker({
		locale: {
			format: "YYYY-MM-DD H:m:s",
		},
		// startDate: moment().startOf("month"),
		// endDate: moment().endOf("month"),
	})
})
