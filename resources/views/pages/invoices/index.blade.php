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
							<th scope="col">Status</th>
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
							<td>
								<span @class(["p-2
									  text-capitalize", "bg-danger-subtle"=> $invoice->status == "not_paid",
									"bg-warning-subtle"=> $invoice->status == "partially_paid",
									"bg-success-subtle" => $invoice->status == "paid",
									])>
									@foreach (explode("_", $invoice->status) as $status)
									{{ $status }}
									@endforeach
								</span>
							</td>
							<td>{{ $invoice->amount ? number_format($invoice->amount) : '-' }}</td>
							<td>
								<div class="d-flex">
									{{-- Show Invoice --}}
									<a href="/invoices/{{ $invoice->id }}"
									   class="btn btn-sm btn-primary me-1">
										<i class="fa fa-eye"></i>
									</a>
									{{-- Show Invoice End --}}
									{{-- Delete Modal --}}
									<div class="mx-1">
										{{-- Confirm Delete Modal End --}}
										<div class="modal fade"
											 id="deleteModal{{ $invoice->id }}"
											 tabIndex="-1"
											 aria-labelledby="deleteModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h1 id="deleteModalLabel"
															class="modal-title fs-5 text-danger">
															Delete Invoice
														</h1>
														<button type="button"
																class="btn-close"
																data-bs-dismiss="modal"
																aria-label="Close"></button>
													</div>
													<div class="modal-body text-wrap">
														Are you sure you want to delete this invoice.
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
														                                                     document.getElementById('deleteForm{{ $invoice->id }}').submit();">
															Delete
														</button>
														<form id="deleteForm{{ $invoice->id }}"
															  action="/invoices/{{ $invoice->id }}"
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
												data-bs-target="#deleteModal{{ $invoice->id }}">
											<i class="fa fa-trash"></i>
										</button>
									</div>
								</div>
								{{-- Delete Modal End --}}
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