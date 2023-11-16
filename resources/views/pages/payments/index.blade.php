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
				<div class="d-flex justify-content-between w-100 align-items-center mx-4">
					<div>
						KES <span class="fs-4">{{ $total }}</span>
						<h4 style="color: gray;">Total</h4>
					</div>
					<div class="border-end py-3 px-4 bg-success-subtle rounded-circle"><i
						   class="fa fa-dollar-sign fs-1"></i></div>
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
					<div class="col-sm-9 mb-2"></div>
					{{-- Date --}}
					<div class="col-sm-2 mb-2">
						<input id=""
							   name="date_received"
							   type="date"
							   value="{{ $request->input('date_received') }}"
							   class="form-control w-100" />
					</div>
					{{-- Date End --}}
					{{-- Search --}}
					<div class="col-sm-1">
						<button type="submit"
								class="btn btn-sm btn-primary ms-auto">
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
					{{-- <a href="/payments/create"
					   class="btn btn-primary"><i class="fa fa-pen-square"></i> Create</a> --}}
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">SN</th>
								<th scope="col">Customer</th>
								<th scope="col">Transaction Ref</th>
								<th scope="col">Payment Channel</th>
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
								<td>{{ $payment->invoice->user->name }}</td>
								<td>{{ $payment->transaction_reference }}</td>
								<td>{{ $payment->payment_channel }}</td>
								<td>KES</td>
								<td>{{ number_format($payment->amount) }}</td>
								<td>{{ $payment->date_received }}</td>
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
				{{ $payments->appends([
				"user_id" => $request->user_id,
				"date_received" => $request->date_received,
				])->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection