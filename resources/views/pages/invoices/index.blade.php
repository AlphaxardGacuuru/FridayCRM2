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
							<th scope="col">#</th>
							<th scope="col">Customer</th>
							<th scope="col">Product</th>
							<th scope="col">Amount</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						<tr>
							<th scope="row">{{ $loop->iteration }}</th>
							<td>{{ $order->user->name }}</td>
							<td>{{ $order->product->name }}</td>
							<td class="text-success">KES {{ $order->total_value }}</td>
							<td>
								<div class="d-flex">
									<div class="mx-1">
										{{-- Confirm Status Modal End --}}
										<div class="modal fade"
											 id="statusModal{{ $order->id }}"
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
						                                                     document.getElementById('statusForm{{ $order->id }}').submit();">
															Update
														</button>
														<form id="statusForm{{ $order->id }}"
															  action="/invoices/{{ $order->id }}"
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
												data-bs-target="#statusModal{{ $order->id }}">
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
				{{ $orders->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection