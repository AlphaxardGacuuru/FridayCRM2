@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Edit Order</h3>
				<a href="/payments"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body">
				<form action="/payments/{{ $payment->id }}"
					  method="POST">
					@csrf
					<input type="hidden"
						   name="_method"
						   value="PUT">
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
							<option value="{{ $user->id }}"
								{{ $user->id == $payment->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
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
							   placeholder="{{ $payment->amount }}">
					</div>
					{{-- Amount End --}}
					{{-- Transaction Ref --}}
					<div class="form-group">
						<label for="transactionInput"
							   class="col-form-label">Transaction Ref</label>
						<input id="transactionInput"
							   type="text"
							   name="transaction_reference"
							   placeholder="{{ $payment->transaction_reference }}"
							   class="form-control">
					</div>
					{{-- Transaction Ref End --}}
					{{-- Payment Channel --}}
					<div class="form-group">
						<label for="paymentInput"
							   class="col-form-label">Payment Channel</label>
						<select id="paymentInput"
								name="payment_channel"
								class="form-control">
							<option value="">Choose a Channel</option>
							@foreach ($channels as $channel)
							<option value="{{ $channel}}"
									{{
									$payment->payment_channel == $channel ? 'selected' : '' }}>{{ $channel }}</option>
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
					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Update Payment</button>
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
	// Function to calculate total value
    function calculateSum() {
        var kraDueInput = parseFloat(document.getElementById('kraDueInput').value) || 0;
        var kebsDueInput = parseFloat(document.getElementById('kebsDueInput').value) || 0;
        var otherChargesInput = parseFloat(document.getElementById('otherChargesInput').value) || 0;

        var sum = kraDueInput + kebsDueInput + otherChargesInput;

        document.getElementById('totalValueInput').value = sum;
    }

    // Attach an event listener to each input field
    document.getElementById('kraDueInput').addEventListener('input', calculateSum);
    document.getElementById('kebsDueInput').addEventListener('input', calculateSum);
    document.getElementById('otherChargesInput').addEventListener('input', calculateSum);
</script>
@endsection