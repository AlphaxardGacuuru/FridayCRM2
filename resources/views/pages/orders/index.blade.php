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
									$request->input("user_id") == $user->id ? 'selected' : ''}}>{{ $user->name }}
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
									$request->input("product_id") == $product->id ? 'selected' : ''}}
								>{{ $product->name }}</option>
							@endforeach
						</select>
					</div>
					{{-- Product End --}}
					{{-- Entry Number --}}
					<div class="col-sm-2 mb-2">
						<input id=""
							   type="number"
							   name="entry_number"
							   placeholder="Entry Number"
							   value="{{ $request->input("
							   entry_number")
							   }}"
							   class="form-control" />
					</div>
					{{-- Entry Number End --}}
					{{-- Status --}}
					<div class="col-sm-2 mb-2">
						<select id=""
								name="status"
								class="form-control">
							<option value="">Select Status</option>
							<option value="pending"
									{{
									$request->input("status") == 'pending' ? 'selected' : ''}}>Pending</option>
							<option value="paid"
									{{
									$request->input("status") == 'paid' ? 'selected' : ''}}
								>Paid</option>
						</select>
					</div>
					{{-- Status End --}}
					{{-- Date --}}
					<div class="col-sm-2 mb-2">
						<input id=""
							   name="date"
							   type="date"
							   value="{{ $request->input("
							   date")
							   }}"
							   class="form-control w-100" />
					</div>
					{{-- Date End --}}
					{{-- Search --}}
					<div class="col-sm-2">
						<button type="submit"
								class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button>
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
					<table class="table">
						<thead>
							<tr>
								<th scope="col">
									<input id="checkAllInput"
										   type="checkbox">
								</th>
								<th scope="col">#</th>
								<th scope="col"
									class="text-uppercase">Entry No</th>
								<th scope="col"
									class="text-uppercase">Vehicle Reg</th>
								<th scope="col"
									class="text-uppercase">CURR</th>
								<th scope="col"
									class="text-uppercase">KRA Due</th>
								<th scope="col"
									class="text-uppercase">KEBS Due</th>
								<th scope="col"
									class="text-uppercase">Other Charges</th>
								<th scope="col"
									class="text-uppercase">Total Value</th>
								<th scope="col"
									class="text-uppercase">Status</th>
								<th scope="col"
									class="text-uppercase">Date</th>
								<th scope="col"
									class="text-uppercase">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $order)
							<tr>
								<td>
									<input id="checkbox{{ $loop->iteration }}"
										   type="checkbox"
										   name="order_ids[]"
										   value="{{ $order->id  }}"
										   onchange="setOrderIds({{ $order->id }})" />
								</td>
								<td scope="row">{{ $loop->iteration }}</td>
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
										  text-capitalize'
										  , 'bg-warning-subtle'=> $order->status == 'pending'
										, 'bg-success-subtle'=> $order->status == 'paid'
										])>
										{{ $order->status }}
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
				{{ $orders->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>

<script>
	var orderIds = []

	/*
	* Toggle Create Invoice Button
	*/ 
	var toggleCreateInvoiceBtn = () => {
		// Toggle Create Invoice visibility
		if (orderIds.length > 0) {
		document.getElementById('invoiceBtn').classList.remove('d-none')
		} else {
		document.getElementById('invoiceBtn').classList.add('d-none')
		}
	}

	/*
	* Handle Setting Order Ids
	*/ 
	var setOrderIds = (id) => {
		var exists = orderIds.some((orderId) => orderId == id)

		if (exists) {
			orderIds = orderIds.filter((orderId) => orderId != id)
		} else {
			orderIds.push(id)
		}

		toggleCreateInvoiceBtn()
	}

	/*
	* Check All Inputs
	*/ 
	var checkAllInput = document.getElementById('checkAllInput')

	checkAllInput.addEventListener('click', (e) => {
		// Select all input elements with IDs containing the word "checkbox"
		const checkboxInputs = document.querySelectorAll('input[id*="checkbox"]');
		
		// Do something with the selected elements, for example, log their IDs
		checkboxInputs.forEach(input => {
			if (e.target.checked) {
				input.checked = true
				// Fill orderIds
				orderIds.push(input.value)
			} else {
				input.checked = false
				// Empty orderIds
				orderIds = []
			}
		});

		toggleCreateInvoiceBtn()
	})

	/*
	* Submit Form
	*/ 
	var onCreateInvoice = () => {
		var formData = new FormData
		formData.append("order_ids", JSON.stringify(orderIds))

		        // Send a POST request using Fetch API
		        fetch('/invoices', {
		            method: "POST",
		            body: formData,
		            headers: {
		                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
		            },
		        }).then((res) => {
					// Redirect on success
					window.location.href = "/invoices"
		        }).catch((err) => {
		            // Handle any errors that occurred during the fetch.
		            console.error(err);
		        });
	}
</script>
@endsection