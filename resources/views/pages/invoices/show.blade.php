@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- end pageheader  -->
<!-- ============================================================== -->
<style>
	.row {
		font-family: "Bookman Old Style", "Garamond", "Times New Roman", serif;
	}

	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {
		font-family: "Bookman Old Style", "Garamond", "Times New Roman", serif;
	}
</style>
{{-- Confirm Payment Modal End --}}
<div class="modal fade"
	 id="paymentModal"
	 tabIndex="-1"
	 aria-labelledby="paymentModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 id="paymentModalLabel"
					class="modal-title fs-5">
					Create Payment
				</h1>
				<button type="button"
						class="btn-close"
						data-bs-dismiss="modal"
						aria-label="Close"></button>
			</div>
			<div class="modal-body text-wrap">
				<form action="/payments"
					  method="POST">
					@csrf
					<input type="hidden"
						   name="invoice_id"
						   value="{{ $invoice->id }}">
					{{-- Customer Channel --}}
					{{-- <div class="form-group">
						<label for="userInput"
							   class="col-form-label">Customer</label>
						<select id="userInput"
								name="user_id"
								class="form-control"
								required>
							<option value="">Choose a Customer</option>
							@foreach ($users as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
						</select>
					</div> --}}
					{{-- Customer End --}}
					{{-- Amount --}}
					<div class="form-group">
						<label for="amountInput"
							   class="col-form-label">Amount</label>
						<input id="amountInput"
							   type="number"
							   name="amount"
							   class="form-control"
							   required>
					</div>
					{{-- Amount End --}}
					{{-- Transaction Ref --}}
					<div class="form-group">
						<label for="transactionInput"
							   class="col-form-label">Transaction Ref</label>
						<input id="transactionInput"
							   type="text"
							   name="transaction_reference"
							   class="form-control">
					</div>
					{{-- Transaction Ref End --}}
					{{-- Payment Channel --}}
					<div class="form-group">
						<label for="paymentInput"
							   class="col-form-label">Payment Channel</label>
						<select id="paymentInput"
								name="payment_channel"
								class="form-control"
								required>
							<option value="">Choose a Channel</option>
							@foreach ($channels as $channel)
							<option value="{{ $channel}}">{{ $channel }}</option>
							@endforeach
						</select>
					</div>
					{{-- Payment Channel End --}}
					{{-- Date --}}
					<div class="form-group">
						<label for="inputText4"
							   class="col-form-label">Date Received</label>
						<input id="inputText4"
							   type="date"
							   name="date_received"
							   class="form-control">
					</div>
					{{-- Date End --}}
					<div class="d-flex justify-content-between">
						<button type="button"
								class="btn btn-light"
								data-bs-dismiss="modal">
							Close
						</button>
						<button type="submit"
								class="btn btn-primary">
							Create Payment
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
{{-- Confirm Delete Modal End --}}

{{-- Create Link --}}
<div class="d-flex justify-content-end mb-4">
	{{-- Button trigger modal --}}
	<button type="button"
			class="btn btn-primary text-white me-2"
			data-bs-toggle="modal"
			data-bs-target="#paymentModal">
		<i class="fa fa-pen-square"></i> Add Payment
	</button>
	<button class="btn btn-secondary me-5"><i class="fa fa-print"></i> Print</button>
</div>
{{-- Create Link End --}}

<div class="row">
	<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card p-5">
			<div class="card-header p-4 border-0">
				<a class="pt-2 d-inline-block"
				   href="index.html">
					<img src="/storage/img/Bulk Main Logo 800x600.png"
						 style="width: 15em; height: auto"
						 loading="lazy"
						 alt=""></a>

				<div class="float-right">
					<div class="mb-0"
						 style="font-size: 4em;">INVOICE</div>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between mb-4">
					<div class="">
						<h5 class="mb-1">Billed To:</h5>
						<div style="color: gray;">{{ $invoice->user->name }}</div>
						<div style="color: gray;">Phone: {{ $invoice->user->phone }}</div>
						<div style="color: gray;">{{ $invoice->user->address }}</div>
					</div>
					<div class="text-end">
						<p class="m-0"
						   style="color: gray;">Invoice No: {{ $invoice->id }}</p>
						<p class="m-0"
						   style="color: gray;">Date: {{ $invoice->created_at }}</p>
					</div>
				</div>
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
							</tr>
							@endforeach
							<tr class="border-3 border-start-0 border-end-0">
								<td colspan="4"
									style="background-color: white;"></td>
								<td class="text-right"
									style="background-color: white;">
									<strong class="text-dark">
										KES {{ $invoice->amount ? number_format($invoice->amount, 2) : '-' }}
									</strong>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-white border-0">
				<h1 class="my-5">Thank you!</h1>

				<div class="d-flex justify-content-between">
					<div>Payment Information</div>
					<div class="text-end">
						<h3 class="text-dark mb-1">Bulk Agencies Limited</h3>
						<div>370-00207 Township Street, Namanga, Kenya</div>
						{{-- <div>Email: info@bulkagencies.co.ke</div> --}}
						{{-- <div>Phone: +254 722 427 629</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection