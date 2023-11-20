@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		{{-- Data --}}
		<div class="card p-4"
			 style="color: gray;">
			<div class="d-flex justify-content-between">
				{{-- Pending --}}
				<div class="d-flex justify-content-between w-50 align-items-center mx-4">
					<div>
						KES <span class="fs-4">{{ number_format($ordersPendingValue) }}</span>
						<h4 style="color: gray;">Pending</h4>
					</div>
					<div class="border-end pe-4"><i class="fa fa-file-alt fs-1"></i></div>
				</div>
				{{-- Pending End --}}
				{{-- Paid --}}
				<div class="d-flex justify-content-between w-50 align-items-center ms-2 me-4">
					<div>
						KES <span class="fs-4">{{ number_format($ordersPaidValue) }}</span>
						<h4 style="color: gray;">Paid</h4>
					</div>
					<div><i class="fa fa-check-square fs-1"></i></div>
				</div>
				{{-- Paid End --}}
			</div>
		</div>
		{{-- Data End --}}

		{{-- Filters --}}
		<div class="card p-4"
			 style="color: gray;">
			<form action="/orders">
				<div class="row">
					<div class="col-sm-2 mb-2">
						<select id=""
								name="user_id"
								class="form-control">
							<option value="">Select Customer</option>
							@foreach ($users as $user)
							<option value="{{ $user->id }}"
									{{
									$request->input('user_id') == $user->id ? 'selected' : ''}}>
								{{ $user->name }}
							</option>
							@endforeach
						</select>
					</div>
					{{-- Customer End --}}
					{{-- Product --}}
					<div class="col-sm-2 mb-2">
						<select id=""
								name="product_id"
								class="form-control">
							<option value="">Select Product</option>
							@foreach ($products as $product)
							<option value="{{ $product->id }}"
									{{
									$request->input("product_id") == $product->id ? 'selected' : ''
								}}>
								{{ $product->name }}
							</option>
							@endforeach
						</select>
					</div>
					{{-- Product End --}}
					{{-- Entry Number --}}
					<div class="col-sm-2 mb-2">
						<input id=""
							   type="number"
							   name="entry_number"
							   placeholder="Entry No"
							   value="{{ $request->input('entry_number') }}"
							   class="form-control" />
					</div>
					{{-- Entry Number End --}}
					{{-- Status --}}
					<div class="col-sm-2 mb-2">
						<select id=""
								name="status"
								class="form-control">
							<option value="">Select Status</option>
							@foreach ($statuses as $status => $slug)
							<option value="{{ $status }}"
									{{
									$request->input("status") == $status ? 'selected' : ''}}>{{ $slug }}</option>
							@endforeach
						</select>
					</div>
					{{-- Status End --}}
					{{-- Date --}}
					<div class="col-sm-2 mb-2">
						<input id=""
							   name="date"
							   type="date"
							   value="{{ $request->input('date') }}"
							   class="form-control w-100" />


						<input type="text"
							   name="daterange"
							   value="01/01/2015 - 01/31/2015" />
					</div>
					{{-- Date End --}}
					{{-- Search --}}
					<div class="col-sm-2">
						<button type="submit"
								class="btn btn-sm btn-primary">
							<i class="fa fa-search"></i> Search
						</button>
					</div>
					{{-- Search End --}}
				</div>
			</form>
		</div>
		{{-- Filters End --}}

		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3>Orders</h3>
				<div class="d-flex justify-content-between">
					{{-- Generate Invoice --}}
					<button id="invoiceBtn"
							class="btn btn-primary d-none mx-2"
							onclick="onCreateInvoice()">
						<i class="fa fa-dollar-sign"></i> Create Invoice
					</button>
					{{-- Generate Invoice End --}}
					<a href="/orders/create"
					   class="btn btn-primary"><i class="fa fa-pen-square"></i> Create</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					{{-- Clear Checkboxes --}}
					<button id="countBtn"
							class="btn btn-outline-primary d-none mb-2 me-2">
					</button>
					<button id="clearBtn"
							class="btn btn-primary d-none mb-2"
							onclick="clearAll()">
						Clear
					</button>
					{{-- Clear Checkboxes End --}}
					<table class="table">
						<thead>
							<tr>
								<th scope="col">
									<input id="checkAllInput"
										   type="checkbox">
								</th>
								<th scope="col">SN</th>
								<th scope="col">Entry No</th>
								<th scope="col">Vehicle Reg</th>
								<th scope="col">Curr</th>
								<th scope="col">Kra Due</th>
								<th scope="col">Kebs Due</th>
								<th scope="col">Other Charges</th>
								<th scope="col">Total Value</th>
								<th scope="col">Status</th>
								<th scope="col">Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $order)
							<tr>
								<td>
									@if ($order->status == "pending")
									<input id="checkbox{{ $order->id }}"
										   type="checkbox"
										   name="order_ids[]"
										   value="{{ $order->id  }}"
										   onclick="setOrderIds({{ $order->id }})" />
									@endif
								</td>
								<td scope="row">
									{{ $loop->iteration + ($orders->perPage() * ($orders->currentPage() - 1)) }}
								</td>
								<td>{{ $order->entry_number }}</td>
								<td>{{ $order->vehicle_registration }}</td>
								<td>KES</td>
								<td>{{ $order->kra_due ? number_format($order->kra_due) : '-' }}</td>
								<td>{{ $order->kebs_due ? number_format($order->kebs_due) : '-' }}</td>
								<td>{{ $order->other_charges ? number_format($order->other_charges) : '-' }}</td>
								<td>{{ $order->total_value ? number_format($order->total_value) : '-' }}</td>
								<td>
									<span @class(['py-2
										  px-4
										  text-capitalize', 'bg-secondary-subtle'=> $order->status == 'pending',
										'bg-primary-subtle' => $order->status == 'invoiced',
										'bg-warning-subtle' => $order->status == 'partially_paid',
										'bg-success-subtle' => $order->status == 'paid'
										])>
										@foreach (explode("_", $order->status) as $status)
										{{ $status }}
										@endforeach
									</span>
								</td>
								<td>{{ $order->date }}</td>
								<td>
									<div class="d-flex">
										<a href="/orders/{{ $order->id }}/edit"
										   class="btn btn-sm btn-primary">
											<i class="fa fa-edit"></i>
										</a>
										<div class="mx-1">
											{{-- Confirm Delete Modal End --}}
											<div class="modal fade"
												 id="deleteModal{{ $order->id }}"
												 tabIndex="-1"
												 aria-labelledby="deleteModalLabel"
												 aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h1 id="deleteModalLabel"
																class="modal-title fs-5 text-danger">
																Delete Order
															</h1>
															<button type="button"
																	class="btn-close"
																	data-bs-dismiss="modal"
																	aria-label="Close"></button>
														</div>
														<div class="modal-body text-wrap">
															Are you sure you want to delete Order.
															This process is irreversible.
														</div>
														<div class="modal-footer justify-content-between">
															<button type="button"
																	class="btn btn-light"
																	data-bs-dismiss="modal">
																Close
															</button>
															<button type="button"
																	class="btn btn-danger text-white"
																	data-bs-dismiss="modal"
																	onclick="event.preventDefault();
						                                                     document.getElementById('deleteForm{{ $order->id }}').submit();">
																Delete
															</button>
															<form id="deleteForm{{ $order->id }}"
																  action="/orders/{{ $order->id }}"
																  method="POST"
																  style="display: none;">
																<input type="hidden"
																	   name="_method"
																	   value="DELETE">
																@csrf
															</form>
														</div>
													</div>
												</div>
											</div>
											{{-- Confirm Delete Modal End --}}

											{{-- Button trigger modal --}}
											<button type="button"
													class="btn btn-sm text-white"
													style="background-color: gray"
													data-bs-toggle="modal"
													data-bs-target="#deleteModal{{ $order->id }}">
												<i class="fa fa-trash"></i>
											</button>
										</div>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-between flex-wrap">
					{{ $orders->appends([
					"user_id" => $request->user_id,
					"product_id" => $request->product_id,
					"entry_number" => $request->entry_number,
					"status" => $request->status,
					"date" => $request->date,
					])->links() }}
					{{-- Increase pagination --}}
					<nav>
						<ul class="pagination">
							<li class="page-item"><span class="page-link">Show per page</span></li>
							<li class="page-item"
								onclick="onPagination(20)"><span class="page-link">20</span>
							</li>
							<li class="page-item"
								onclick="onPagination(50)"><span class="page-link">50</span></li>
							<li class="page-item"
								onclick="onPagination(100)"><span class="page-link">100</span></li>
						</ul>
					</nav>
					{{-- Increase pagination End --}}
				</div>
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>

<script>
	var storageOrderIds = () => {
		var storageOrderIds = sessionStorage.getItem("orderIds")
		
		return storageOrderIds ? JSON.parse(storageOrderIds) : []
	}

	var orderIds = storageOrderIds()

	/*
	* Toggle Create Invoice Button
	*/ 
	var toggleBtns = () => {
		// Toggle Create Invoice, Count and Clear buttons visibility
		if (storageOrderIds().length > 0) {
			document.getElementById('invoiceBtn').classList.remove('d-none')
			document.getElementById("clearBtn").classList.remove("d-none")
			document.getElementById("countBtn").classList.remove("d-none")
			document.getElementById("countBtn").innerText = storageOrderIds().length + " selected"
		} else {
			document.getElementById('invoiceBtn').classList.add('d-none')
			document.getElementById("clearBtn").classList.add("d-none")
			document.getElementById("countBtn").classList.add("d-none")
		}
	}

	/*
	* Check checkbox inputs on load based on session storage
	*/ 
	if (orderIds.length > 0 && orderIds[0] != "all") {
		// Toggle Buttons
		toggleBtns()

		// Check boxes
		orderIds.forEach((orderId)=> {
			var checkboxInput = document.getElementById(`checkbox${orderId}`)

			if (checkboxInput) {
				checkboxInput.checked = true
			}
		})
	} 

	/*
	* Check all inputs on load based on session storage
	*/
	if (orderIds[0] == "all") {
		// Select all input elements with IDs containing the word "checkbox"
		document.getElementById("checkAllInput").checked = true

		const checkboxInputs = document.querySelectorAll('input[id*="checkbox"]');
		
		// Do something with the selected elements, for example, log their IDs
		checkboxInputs.forEach((input) => {
			input.checked = true
			
			// Toggle buttons
			toggleBtns()
			document.getElementById("countBtn").innerText = "All selected"
		})
	}

	/*
	* Clear All checkboxes
	*/ 
	var clearAll = () => {
		// Set orderIds to all in Session Storage
		sessionStorage.removeItem("orderIds")

		// Toggle buttons
		toggleBtns()
		
		// Select all input elements with IDs containing the word "checkbox"
		document.getElementById("checkAllInput").checked = false

		const checkboxInputs = document.querySelectorAll('input[id*="checkbox"]');
		
		checkboxInputs.forEach(input => input.checked = false);
	}

	/*
	* Check All Inputs
	*/ 
	var checkAllInput = document.getElementById('checkAllInput')

	checkAllInput.addEventListener('click', (e) => {

		if (e.target.checked) {
			// Set orderIds to all in Session Storage
			sessionStorage.setItem("orderIds", JSON.stringify(["all"]))
			
			// Toggle buttons
			toggleBtns()

			document.getElementById("countBtn").innerText = "All selected"
		} else {
			// Set orderIds to all in Session Storage
			sessionStorage.removeItem("orderIds")
			
			toggleBtns()
		}

		// Select all input elements with IDs containing the word "checkbox"
		const checkboxInputs = document.querySelectorAll('input[id*="checkbox"]');
		
		// Do something with the selected elements, for example, log their IDs
		checkboxInputs.forEach((input) => {
			if (e.target.checked) {
				input.checked = true
			} else {
				input.checked = false
			}
		});
	})

	/*
	* Handle Setting Order Ids
	*/ 
	var setOrderIds = (id) => {
		// Check if all are selected and deselect

		var allAreSelected = storageOrderIds()[0] == "all"
		
		if (allAreSelected) {
			document.getElementById("checkAllInput").checked = false
			
			document.querySelectorAll('input[id*="checkbox"]')
				.forEach((input) => input.checked = false)

			// Remove OrderIds from session
			sessionStorage.removeItem("orderIds")

			// Toggle buttons
			toggleBtns()
		} else {
			var orderIds = storageOrderIds()

			var exists = orderIds.some((orderId) => orderId == id)
			
			if (exists) {
				orderIds = orderIds.filter((orderId) => orderId != id)
			} else {
				orderIds.push(id)
			}
			
			// Set orderIds to all in Session Storage
			sessionStorage.setItem("orderIds", JSON.stringify(orderIds))
			
			// Show counter and clear
			toggleBtns()
		}
	}

	/*
	* Submit Form
	*/ 
	var onCreateInvoice = () => {

		// Get Url params
		const urlParams = new URLSearchParams(window.location.search);
		const user_id = urlParams.get('user_id');
		const product_id = urlParams.get('product_id');
		const entry_number = urlParams.get('entry_number');
		const status = urlParams.get('status');
		const date = urlParams.get('date');

		var formData = new FormData
		formData.append("order_ids", sessionStorage.getItem("orderIds"))
		user_id && formData.append("user_id", user_id)
		product_id && formData.append("product_id", product_id)
		entry_number && formData.append("entry_number", entry_number)
		status && formData.append("status", status)
		date && formData.append("date", date)

	    // Send a POST request using Fetch API
	    fetch('/invoices', {
	        method: "POST",
	        body: formData,
	        headers: {
	            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
	        },
	    }).then((res) => {
			// Clear Session Storage
			sessionStorage.removeItem("orderIds")
			// Redirect on success
			window.location.href = "/invoices"
	    }).catch((err) => {
	        // Handle any errors that occurred during the fetch.
	        console.error(err);
	    });
	}

	/*
	* Handle Pagination
	*/ 
	var onPagination = (int) => {
		// Get the current URL
		const currentUrl = window.location.href;
		
		// Extract the query string from the current URL
		const queryString = currentUrl.split('?')[1];
		
		// Create a new URLSearchParams object with the extracted query string
		const params = new URLSearchParams(queryString);
		
		// Append or modify parameters as needed
		params.set('pagination', int);
		// params.set('param1', 'updatedValue');
		
		// Reconstruct the URL with updated parameters
		const baseUrl = currentUrl.split('?')[0];
		const finalUrl = baseUrl + '?' + params.toString();
		
		window.location.href = finalUrl
	}

</script>
@endsection