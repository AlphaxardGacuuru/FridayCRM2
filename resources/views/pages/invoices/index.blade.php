@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Invoices</h3>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">SN</th>
							<th scope="col">Invoice No</th>
							<th scope="col">Customer</th>
							<th scope="col">Amount</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($invoices as $invoice)
						<tr>
							<th scope="row">{{ $loop->iteration + ($invoices->perPage() * ($invoices->currentPage() -
								1)) }}</th>
							<td>{{ $invoice->id }}</td>
							<td>{{ $invoice->user->name }}</td>
							<td>{{ $invoice->amount ? number_format($invoice->amount) : '-' }}</td>
							<td>
								<div class="d-flex">
									{{-- Show --}}
									<a href="/invoices/{{ $invoice->id }}"
									   class="btn btn-sm btn-primary me-1">
										<i class="fa fa-eye"></i>
									</a>
									{{-- Show End --}}
									<div class="mx-1">
										{{-- Confirm Status Modal End --}}
										<div class="modal fade"
											 id="statusModal{{ $invoice->id }}"
											 tabIndex="-1"
											 aria-labelledby="statusModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h1 id="statusModalLabel"
															class="modal-title fs-5 text-warning">
															Set Status to Paid
														</h1>
														<button type="button"
																class="btn-close"
																data-bs-dismiss="modal"
																aria-label="Close"></button>
													</div>
													<div class="modal-body text-wrap">
														Are you sure you want to change the status.
														This process is irreversible.
													</div>
													<div class="modal-footer justify-content-between">
														<button type="button"
																class="btn btn-light"
																data-bs-dismiss="modal">
															Close
														</button>
														<button type="button"
																class="btn btn-success text-white"
																data-bs-dismiss="modal"
																onclick="event.preventDefault();
						                                                     document.getElementById('statusForm{{ $invoice->id }}').submit();">
															Update
														</button>
														<form id="statusForm{{ $invoice->id }}"
															  action="/invoices/{{ $invoice->id }}"
															  method="POST"
															  style="display: none;">
															<input type="hidden"
																   name="_method"
																   value="PUT">
															<input type="hidden"
																   name="status"
																   value="paid">
															@csrf
														</form>
													</div>
												</div>
											</div>
										</div>
										{{-- Confirm Status Modal End --}}

										{{-- Button trigger modal --}}
										<button type="button"
												class="btn btn-sm btn-success text-white"
												data-bs-toggle="modal"
												data-bs-target="#statusModal{{ $invoice->id }}">
											Set Paid
										</button>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				{{ $invoices->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection