@extends('layouts.app')

@section('content')


<!-- content -->

<div class="row">

	<!-- profile -->

	<div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">

		<!-- card profile -->

		<div class="card">
			<div class="card-body">
				<div class="user-avatar text-center d-block">
					{{-- <img src="assets/images/avatar-1.jpg"
						 alt="User Avatar"
						 class="rounded-circle user-avatar-xxl"> --}}
				</div>
				<div class="text-center">
					<h2 class="font-24 mb-0">{{ $user->name}}</h2>
					{{-- <p>Project Manager @Influnce</p> --}}
				</div>
			</div>
			<div class="card-body border-top">
				<h3 class="font-16">Contact Information</h3>
				<div class="">
					<ul class="list-unstyled mb-0">
						<li class="mb-2"><i class="fa fa-envelope mr-2"></i>{{ $user->email }}</li>
						<li class="mb-2"><i class="fa fa-phone mr-2"></i>{{ $user->phone }}</li>
						<li class="mb-2"><i class="fa fa-calendar mr-2"></i>{{ $user->created_at }}</li>
						<li class="mb-2"><i class="fa fa-key mr-2"></i>{{ $user->kra_pin }}</li>
						<li class="mb-2"><i class="fa fa-map-marker-alt mr-2"></i>{{ $user->address }}</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- end card profile -->

	</div>

	<!-- end profile -->


	<!-- campaign data -->

	<div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">

		<!-- campaign tab one -->

		<div class="influence-profile-content pills-regular">
			<ul class="nav nav-pills mb-3 nav-justified"
				id="pills-tab"
				role="tablist">
				<li class="nav-item me-2">
					<a class="nav-link active"
					   id="pills-campaign-tab"
					   data-toggle="pill"
					   href="#pills-campaign"
					   role="tab"
					   aria-controls="pills-campaign"
					   aria-selected="true">Orders</a>
				</li>
				<li class="nav-item me-2">
					<a class="nav-link"
					   id="pills-packages-tab"
					   data-toggle="pill"
					   href="#pills-packages"
					   role="tab"
					   aria-controls="pills-packages"
					   aria-selected="false">Invoices</a>
				</li>
				<li class="nav-item me-2">
					<a class="nav-link"
					   id="pills-review-tab"
					   data-toggle="pill"
					   href="#pills-review"
					   role="tab"
					   aria-controls="pills-review"
					   aria-selected="false">Payments</a>
				</li>
				<li class="nav-item">
					<a class="nav-link"
					   id="pills-msg-tab"
					   data-toggle="pill"
					   href="#pills-msg"
					   role="tab"
					   aria-controls="pills-msg"
					   aria-selected="false">Statements</a>
				</li>
			</ul>
			<div class="tab-content"
				 id="pills-tabContent">
				{{-- Orders Tab --}}
				<div class="tab-pane fade show active"
					 id="pills-campaign"
					 role="tabpanel"
					 aria-labelledby="pills-campaign-tab">
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
							<div class="card p-4 d-none"
								 style="color: gray;">
								<form action="/orders">
									<div class="row">
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
														$request->input("status") == $status ? 'selected' : ''}}>{{
													$slug }}</option>
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
														<input id="checkbox{{ $loop->iteration }}"
															   type="checkbox"
															   name="order_ids[]"
															   value="{{ $order->id  }}"
															   onchange="setOrderIds({{ $order->id }})" />
														@endif
													</td>
													<td scope="row">
														{{ $loop->iteration + ($orders->perPage() *
														($orders->currentPage() - 1)) }}
													</td>
													<td>{{ $order->entry_number }}</td>
													<td>{{ $order->vehicle_registration }}</td>
													<td>KES</td>
													<td>{{ $order->kra_due ? number_format($order->kra_due) : '-' }}
													</td>
													<td>{{ $order->kebs_due ? number_format($order->kebs_due) : '-' }}
													</td>
													<td>{{ $order->other_charges ? number_format($order->other_charges)
														: '-' }}</td>
													<td>{{ $order->total_value ? number_format($order->total_value) :
														'-' }}</td>
													<td>
														<span @class(['py-2
															  px-4
															  text-capitalize', 'text-nowrap'
															  , 'bg-secondary-subtle'=> $order->status == 'pending',
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
																			<div
																				 class="modal-footer justify-content-between">
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
									{{ $orders->appends([
									"user_id" => $request->user_id,
									"product_id" => $request->product_id,
									"entry_number" => $request->entry_number,
									"status" => $request->status,
									"date" => $request->date,
									])->links() }}
								</div>
							</div>
						</div>
						{{-- end basic table --}}
					</div>
				</div>
				{{-- Orders Tab End --}}
				{{-- Invoices Tab --}}
				<div class="tab-pane fade"
					 id="pills-packages"
					 role="tabpanel"
					 aria-labelledby="pills-packages-tab">
					<div class="row">
						{{-- basic table --}}
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="d-flex justify-content-between card-header">
									<h3 class="">Invoices</h3>
								</div>
								<div class="card-body">
									<div class="table-responsive">
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
													<th scope="row">{{ $loop->iteration + ($invoices->perPage() *
														($invoices->currentPage() -
														1)) }}</th>
													<td>{{ $invoice->id }}</td>
													<td>{{ $invoice->user->name }}</td>
													<td>
														<span @class(["p-2
															  text-capitalize", "bg-danger-subtle"=> $invoice->status ==
															"not_paid",
															"bg-warning-subtle"=> $invoice->status == "partially_paid",
															"bg-success-subtle" => $invoice->status == "paid",
															])>
															@foreach (explode("_", $invoice->status) as $status)
															{{ $status }}
															@endforeach
														</span>
													</td>
													<td>{{ $invoice->amount ? number_format($invoice->amount) : '-' }}
													</td>
													<td>
														{{-- Show Invoice --}}
														<a href="/invoices/{{ $invoice->id }}"
														   class="btn btn-sm btn-primary me-1">
															<i class="fa fa-eye"></i>
														</a>
														{{-- Show Invoice End --}}
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								<div class="card-footer">
									{{ $invoices->links() }}
								</div>
							</div>
						</div>
						{{-- end basic table --}}
					</div>
				</div>
				{{-- Invoices Tab End --}}
				{{-- Payments Tab --}}
				<div class="tab-pane fade"
					 id="pills-review"
					 role="tabpanel"
					 aria-labelledby="pills-review-tab">
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
											KES <span class="fs-4">{{ $totalPayments }}</span>
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
							<div class="card p-4 d-none"
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
													<td>{{ $payment->user->name }}</td>
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
																			<div
																				 class="modal-footer justify-content-between">
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
				</div>
				{{-- Payments Tab End --}}
				{{-- Statements Tab --}}
				<div class="tab-pane fade"
					 id="pills-msg"
					 role="tabpanel"
					 aria-labelledby="pills-msg-tab">
					<div class="row">
						{{-- basic table --}}
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="d-flex justify-content-between card-header">
									<h3>Statements</h3>
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
													<th>SN</th>
													<th>Type</th>
													<th>Date</th>
													<th>Curr</th>
													<th>Debit</th>
													<th>Credit</th>
													<th>Balance</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($statements as $statement)
												<tr>
													<td scope="row">{{ $loop->iteration }}</td>
													<td>{{ $statement->type }}</td>
													<td>{{ $statement->date }}</td>
													<td>KES</td>
													<td>{{ $statement->debit ? number_format($statement->debit) : "-" }}</td>
													<td>{{ $statement->credit ? number_format($statement->credit) : "-" }}</td>
													<td>{{ $statement->balance }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- Statements Tab End --}}
			</div>
		</div>

		<!-- end campaign tab one -->

	</div>

	<!-- end campaign data -->

</div>

@endsection