$(function () {
	$('input[name="daterange"]').daterangepicker({
		locale: {
			format: "MM/DD/YYYY",
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
				picker.startDate.format("MM/DD/YYYY") +
					" - " +
					picker.endDate.format("MM/DD/YYYY")
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
