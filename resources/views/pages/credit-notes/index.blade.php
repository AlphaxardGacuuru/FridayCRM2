@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		{{-- Data --}}
		<div class="card p-4"
			 style="color: gray;">
			<div class="d-flex justify-content-between">
				{{-- Billed --}}
				<div class="d-flex justify-content-between w-50 align-items-center mx-4">
					<div>
						KES <span class="fs-4">{{ number_format($totalBilled) }}</span>
						<h4 style="color: gray;">Total Amount</h4>
					</div>
					<div class="border-end pe-4"><i class="fa fa-file-alt fs-1"></i></div>
				</div>
				{{-- Billed End --}}
				{{-- Paid --}}
				<div class="d-flex justify-content-between w-50 align-items-center ms-2 me-4">
					<div>
						KES <span class="fs-4">{{ number_format($totalPaid) }}</span>
						<h4 style="color: gray;">Used</h4>
					</div>
					<div class="border-end pe-4"><i class="fa fa-check-square fs-1"></i></div>
				</div>
				{{-- Paid End --}}
				{{-- Balance --}}
				<div class="d-flex justify-content-between w-50 align-items-center ms-2 me-4">
					<div>
						KES <span class="fs-4">{{ number_format($totalBilled - $totalPaid) }}</span>
						<h4 style="color: gray;">Balance</h4>
					</div>
					<div><i class="fa fa-balance-scale fs-1"></i></div>
				</div>
				{{-- Balance End --}}
			</div>
		</div>
		{{-- Data End --}}

		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Credit Notes</h3>
				<div class="d-flex justify-content-between">
					<a href="/credit-notes/create"
					   class="btn btn-primary"><i class="fa fa-pen-square"></i> Create</a>
				</div>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Credit Note #</th>
							<th scope="col">Credit Note Date</th>
							<th scope="col">Status</th>
							<th scope="col">Project</th>
							<th scope="col">Reference #</th>
							<th scope="col">Amount</th>
							<th scope="col">Remaining Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($creditNotes as $creditNote)
						<tr>
							<td>{{ $creditNote->id }}</td>
							<td>{{ $creditNote->date }}</td>
							<td>
								<span @class(["p-2
									  text-capitalize", "bg-danger-subtle"=> $creditNote->status == "not_paid",
									"bg-warning-subtle"=> $creditNote->status == "partially_paid",
									"bg-success-subtle" => $creditNote->status == "paid",
									"bg-dark-subtle" => $creditNote->status == "over_paid",
									])>
									@foreach (explode("_", $creditNote->status) as $status)
									{{ $status }}
									@endforeach
								</span>
							</td>
							<td>{{ $creditNote->project }}</td>
							<td>{{ $creditNote->invoice_id }}</td>
							<td>{{ $creditNote->amount ? number_format($creditNote->amount) : '-' }}</td>
							<td>{{ $creditNote->remaining_amount ? number_format($creditNote->remaining_amount) : '-' }}
							</td>
							<td>
								<div class="d-flex">
									{{-- Show Credit Note --}}
									<a href="/creditNotes/{{ $creditNote->id }}"
									   class="btn btn-sm btn-primary me-1">
										<i class="fa fa-eye"></i>
									</a>
									{{-- Show Credit Note End --}}
									{{-- Edit --}}
									<a href="/creditNotes/{{ $creditNote->id }}/edit"
									   class="btn btn-sm btn-primary">
										<i class="fa fa-edit"></i>
									</a>
									{{-- Edit End --}}
									{{-- Delete Modal --}}
									<div class="mx-1">
										{{-- Confirm Delete Modal End --}}
										<div class="modal fade"
											 id="deleteModal{{ $creditNote->id }}"
											 tabIndex="-1"
											 aria-labelledby="deleteModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h1 id="deleteModalLabel"
															class="modal-title fs-5 text-danger">
															Delete Credit Note
														</h1>
														<button type="button"
																class="btn-close"
																data-bs-dismiss="modal"
																aria-label="Close"></button>
													</div>
													<div class="modal-body text-wrap">
														Are you sure you want to delete this creditNote.
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
														                                                     document.getElementById('deleteForm{{ $creditNote->id }}').submit();">
															Delete
														</button>
														<form id="deleteForm{{ $creditNote->id }}"
															  action="/creditNotes/{{ $creditNote->id }}"
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
												data-bs-target="#deleteModal{{ $creditNote->id }}">
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
				{{ $creditNotes->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection