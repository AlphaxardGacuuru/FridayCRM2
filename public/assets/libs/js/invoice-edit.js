$(document).ready(function () {
	// Add new dropdown on button click
	const dropdownList = $(".dropdown-list")

	// Create list items from the orders array
	var listItems = orders
		.map(function (order) {
			return `
				<label class="d-block">
					<li class="border-bottom dropdown-item">
						<div class="d-flex justify-content-start">
							<input 
								type="checkbox" 
								name="addOrderIds[]" 
								value=${order.id}
								class="me-1" />
								${order.entry_number}
						</div>
					</li>
				</label>
				`
		})
		.join("")

	const dropdown = `<div class="dropdown mb-3 mt-2">
                                		<button 
											class="btn btn-outline-light w-100" 
											type="button" id="dropdownMenuButton" 
											data-bs-toggle="dropdown" 
											aria-expanded="false">
                                    			Add Order
										</button>
                                <ul 
									class="dropdown-menu w-100 p-2" 
									aria-labelledby="dropdownMenuButton">
                                    	<li>
											<input 
												class="form-control dropdown-search mb-2" 
												type="text" 
												placeholder="Search by Entry No">
										</li>
										<div class="overflow-y-scroll" style="max-height: 10em;">${listItems}</div>
                                </ul>
                            </div>`

	dropdownList.append(dropdown)

	// Search functionality within dropdowns
	$(".dropdown-list").on("input", ".dropdown-search", function () {
		const searchTerm = $(this).val().toLowerCase()
		const dropdownMenu = $(this).closest(".dropdown").find(".dropdown-menu")
		dropdownMenu.find(".dropdown-item").each(function () {
			const textValue = $(this).text().toLowerCase()
			$(this).toggle(textValue.indexOf(searchTerm) > -1)
		})
	})
})
