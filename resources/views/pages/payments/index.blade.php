@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		{{-- Data --}}
		<div class="card p-4"
			 style="color: gray;">
			<div class="d-flex justify-content-between">
				{{-- Total --}}
				<div class="d-flex justify-content-between w-50 align-items-center mx-4">
					<div>
						KES <span class="fs-4">{{ $total }}</span>
						<h4 style="color: gray;">Total</h4>
					</div>
					<div class="bpayment-end pe-4"><i class="fa fa-file-alt fs-1"></i></div>
				</div>
				{{-- Total End --}}
			</div>
		</div>
		{{-- Data End --}}

		{{-- Filters --}}
		<div class="card p-4"
			 style="color: gray;">
			<form action="/payments">
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
					{{-- Date --}}
					<div class="col-sm-2 mb-2">
						<input id=""
							   name="date"
							   type="date"
							   value="{{ $request->input('date') }}"
							   class="form-control w-100" />
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
				<h3>Payments</h3>
				<div class="d-flex justify-content-between">
					<a href="/payments/create"
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
								<th scope="col">SN</th>
								<th scope="col">Customer</th>
								<th scope="col">Type</th>
								<th scope="col">Curr</th>
								<th scope="col">Amount</th>
								<th scope="col">Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($payments as $payment)
							<tr>
								<td scope="row">{{ $loop->iteration +
									($payments->perPage() *
									($payments->currentPage() - 1)) }}</td>
								<td>{{ $payment->user->name }}</td>
								<td>{{ $payment->type }}</td>
								<td>KES</td>
								<td>{{ $payment->amount }}</td>
								<td>{{ $payment->created_at }}</td>
								<td>
									<div class="d-flex">
										<a href="/payments/{{ $payment->id }}/edit"
										   class="btn btn-sm btn-primary">
											<i class="fa fa-edit"></i>
										</a>
										<div class="mx-1">
											{{-- Confirm Delete Modal End --}}
											<div class="modal fade"
												 id="deleteModal{{ $payment->id }}"
												 tabIndex="-1"
												 aria-labelledby="deleteModalLabel"
												 aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h1 id="deleteModalLabel"
																class="modal-title fs-5 text-danger">
																Delete Payment
															</h1>
															<button type="button"
																	class="btn-close"
																	data-bs-dismiss="modal"
																	aria-label="Close"></button>
														</div>
														<div class="modal-body text-wrap">
															Are you sure you want to delete Payment.
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
						                                                     document.getElementById('deleteForm{{ $payment->id }}').submit();">
																Delete
															</button>
															<form id="deleteForm{{ $payment->id }}"
																  action="/payments/{{ $payment->id }}"
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
													data-bs-target="#deleteModal{{ $payment->id }}">
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
				{{ $payments->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>

<script>
	var paymentIds = []

	/*
	* Toggle Create Invoice Button
	*/ 
	var toggleCreateInvoiceBtn = () => {
		// Toggle Create Invoice visibility
		if (paymentIds.length > 0) {
		document.getElementById('invoiceBtn').classList.remove('d-none')
		} else {
		document.getElementById('invoiceBtn').classList.add('d-none')
		}
	}

	/*
	* Handle Setting Payment Ids
	*/ 
	var setPaymentIds = (id) => {
		var exists = paymentIds.some((paymentId) => paymentId == id)

		if (exists) {
			paymentIds = paymentIds.filter((paymentId) => paymentId != id)
		} else {
			paymentIds.push(id)
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
				// Fill paymentIds
				paymentIds.push(input.value)
			} else {
				input.checked = false
				// Empty paymentIds
				paymentIds = []
			}
		});

		toggleCreateInvoiceBtn()
	})

	/*
	* Submit Form
	*/ 
	var onCreateInvoice = () => {
		var formData = new FormData
		formData.append("payment_ids", JSON.stringify(paymentIds))

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