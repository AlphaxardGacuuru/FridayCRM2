@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Create Order</h3>
				<a href="/orders"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body">
				<form action="/orders"
					  method="POST">
					@csrf
					<div class="form-group">
						<label for="user"
							   class="col-form-label">Customer</label>
						<select id="user"
								name="user_id"
								class="form-control"
								required>
							<option value="">Choose a Customer</option>
							@foreach ($users as $user)
							<option value="{{ $user->id}}">{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="user"
							   class="col-form-label">Product</label>
						<select id="product"
								name="product_id"
								class="form-control"
								required>
							<option value="">Choose a Product</option>
							@foreach ($products as $product)
							<option value="{{ $product->id}}">{{ $product->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="inputText4"
							   class="col-form-label">Date</label>
						<input id="inputText4"
							   type="date"
							   name="date"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="inputText4"
							   class="col-form-label">Vehicle Registration</label>
						<input id="vehicle_registration"
							   type="text"
							   name="vehicle_registration"
							   placeholder="Vehicle Registration"
							   class="form-control"
							   required>
					</div>
					<div class="form-group">
						<label for="inputText4"
							   class="col-form-label">Entry Number</label>
						<input id="entry_number"
							   type="text"
							   name="entry_number"
							   placeholder="Entry Number"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="kraDueInput"
							   class="col-form-label">Kra Due</label>
						<input id="kraDueInput"
							   type="number"
							   name="kra_due"
							   placeholder="Enter Amount"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="kebsDueInput"
							   class="col-form-label">Kebs Due</label>
						<input id="kebsDueInput"
							   type="number"
							   name="kebs_due"
							   placeholder="Enter Amount"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="otherChargesInput"
							   class="col-form-label">Other Charges</label>
						<input id="otherChargesInput"
							   type="number"
							   name="other_charges"
							   placeholder="Enter Amount"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="totalValueInput"
							   class="col-form-label">Total Value</label>
						<input id="totalValueInput"
							   type="number"
							   name="total_value"
							   class="form-control">
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Create Order</button>
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