$(function () {
	$('input[name="daterange"]').daterangepicker({
		locale: {
			format: "YYYY-MM-DD H:m:s",
		},
		// startDate: moment().startOf("year"),
		// endDate: moment().endOf("year"),
		autoUpdateInput: false,
		locale: {
			cancelLabel: "Clear",
		},
	})

	$('input[name="daterange"]').on(
		"apply.daterangepicker",
		function (ev, picker) {
			$(this).val(
				picker.startDate.format("YYYY-MM-DD H:m:s") +
					" - " +
					picker.endDate.format("YYYY-MM-DD H:m:s")
			)
		}
	)

	$('input[name="daterange"]').on(
		"cancel.daterangepicker",
		function (ev, picker) {
			$(this).val("")
		}
	)
})
