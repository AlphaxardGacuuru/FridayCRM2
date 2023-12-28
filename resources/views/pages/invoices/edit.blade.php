@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Edit Invoice</h3>
				<a href="/invoices"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body">
				<form action="/invoices/{{ $invoice->id }}"
					  method="POST">
					@csrf
					<input type="hidden"
						   name="_method"
						   value="PUT" />
					{{-- Invoice ID --}}
					<div class="form-group">
						<label for="invoiceIdInput"
							   class="col-form-label">Invoice ID</label>
						<input id="invoiceIdInput"
							   type="number"
							   name="id"
							   placeholder="{{ $invoice->id }}"
							   class="form-control"
							   disabled>
					</div>
					{{-- Invoice ID End --}}
					{{-- Customer --}}
					<div class="form-group">
						<label for="user_id"
							   class="col-form-label">Customer</label>
						<select id="user_id"
								name="user_id"
								class="form-control">
							@foreach ($users as $user)
							<option value="{{ $user->id }}"
									{{
									$invoice->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
					{{-- Customer End --}}
					{{-- Order --}}
					<div class="form-group my-4">
						<label for="user_id"
							   class="col-form-label">Orders</label>
						<div class="table-responsive-sm">
							<table class="table">
								<thead>
									<tr>
										<th class="center"
											style="background-color: white;">SN</th>
										<th class="text-center"
											style="background-color: white;">Entry No</th>
										<th class="text-center"
											style="background-color: white;">Vehicle Reg</th>
										<th class="text-center"
											style="background-color: white;">Date</th>
										<th class="right text-right"
											style="background-color: white;">Total</th>
										<th class="right text-right"
											style="background-color: white;"></th>
									</tr>
								</thead>
								<tbody>
									@foreach ($items as $item)
									<tr>
										<td class="center"
											style="background-color: white;">{{ $loop->iteration }}</td>
										<td class="text-center"
											style="background-color: white;">{{ $item->entry_number }}</td>
										<td class="text-center"
											style="background-color: white;">{{ $item->vehicle_registration }}</td>
										<td class="text-center"
											style="background-color: white;">{{ $item->date }}</td>
										<td class="right text-right"
											style="background-color: white;">{{ $item->total_value ?
											number_format($item->total_value, 2) : '-' }}
										</td>
										<td class="right text-right"
											style="background-color: white;">
											<button type="button"
													class="btn btn-sm text-white"
													style="background-color: gray"
													onclick="
														event.preventDefault();
														
														// Get the form element by its ID
														var deleteForm = document.getElementById('deleteForm');
										
														// Create a hidden input field
														var hiddenInput = document.createElement('input');
														hiddenInput.type = 'hidden';
														hiddenInput.name = 'removeOrderId'; 
														hiddenInput.value = {{ $item->id }};
										
														// Append the hidden input to the form
														deleteForm.appendChild(hiddenInput);
														document.getElementById('deleteForm').submit();">
												<i class="fa fa-trash"></i>
											</button>
											<form id="deleteForm"
												  action="/invoices/{{ $invoice->id }}"
												  method="POST"
												  style="display: none;">
												<input type="hidden"
													   name="_method"
													   value="PUT">
												@csrf
											</form>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="dropdown-list">
							<form id="editForm"
								  action="/invoices/{{ $invoice->id }}"
								  method="POST"
								  style="display: none;">
								<input type="hidden"
									   name="_method"
									   value="PUT">
								@csrf
							</form>
						</div>
					</div>
					{{-- Order End --}}
					{{-- Amount --}}
					<div class="form-group">
						<label for="amountInput"
							   class="col-form-label">Amount</label>
						<input id="amountInput"
							   type="number"
							   name="id"
							   placeholder="{{ $invoice->amount }}"
							   class="form-control"
							   disabled>
					</div>
					{{-- Amount End --}}
					{{-- Status --}}
					<div class="form-group">
						<label for="statusInput"
							   class="col-form-label">Status</label>
						<input id="statusInput"
							   type="text"
							   name="status"
							   placeholder="{{ $invoice->status }}"
							   class="form-control"
							   disabled>
					</div>
					{{-- Status End --}}
					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Update Invoice</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- end basic form  -->
<!-- ============================================================== -->
<script>
	// Assign PHP variable $orders to a JavaScript variable
    var orders = @json($orders);
</script>
@endsection