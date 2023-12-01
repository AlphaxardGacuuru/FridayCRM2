$(function () {
	$('input[name="daterange"]').daterangepicker({
		locale: {
			format: "YYYY-MM-DD H:m:s",
		},
		// startDate: moment().startOf("year"),
		// endDate: moment().endOf("year"),
		autoUpdateInput: false,
	})
})
