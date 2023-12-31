@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Create Credit Note</h3>
				<a href="/credit-notes"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body border-bottom">
				<form action="/credit-notes"
					  method="POST">
					@csrf

					<div class="row">
						<div class="col-sm-6">
							{{-- Customer --}}
							<div class="form-group">
								<label for="user"
									   class="col-form-label">
									<span class="text-danger">*</span>Customer</label>
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
							{{-- Customer End --}}
							<div class="d-flex justify-content-between">
								{{-- Date --}}
								<div class="form-group w-50 me-2">
									<label for="inputDate"
										   class="col-form-label">
										<span class="text-danger">*</span>Credit Note Date</label>
									<input id="inputDate"
										   type="date"
										   name="date"
										   class="form-control">
								</div>
								{{-- Date End --}}
								{{-- # --}}
								<div class="form-group w-50">
									<label for="inputNo"
										   class="col-form-label">
										<span class="text-danger">*</span>Credit Note #</label>
									<div class="input-group">
										<div class="input-group input-group-sm mb-3">
											<div class="input-group-prepend"><span class="input-group-text">CN-</span>
											</div>
											<input type="text"
												   placeholder="No"
												   class="form-control">
										</div>
									</div>
								</div>
								{{-- # End --}}
							</div>
						</div>

						<div class="col-sm-6">
							<div class="d-flex justify-content-between">
								{{-- Currency --}}
								<div class="form-group w-50 me-2">
									<label for="inputCurrency"
										   class="col-form-label">
										<span class="text-danger">*</span>Currency</label>
									<input id="inputCurrency"
										   type="text"
										   name="currency"
										   placeholder="KES"
										   class="form-control"
										   disabled>
								</div>
								{{-- Currency End --}}
								{{-- Discount Type --}}
								<div class="form-group w-50">
									<label for="inputDiscount"
										   class="col-form-label">
										<span class="text-danger">*</span>Discount Type #
									</label>
									<select id="user"
											name="discount_type"
											class="form-control"
											required>
										<option value="">No Discount</option>
									</select>
								</div>
								{{-- Discount Type End --}}
							</div>

							{{-- Reference --}}
							<div class="form-group">
								<label for="inputReference"
									   class="col-form-label">
									<span class="text-danger">*</span>Reference #
								</label>
								<div class="input-group input-group-sm mb-3">
									<input type="text"
										   id="inputReference"
										   placeholder=""
										   class="form-control">
								</div>
							</div>
							{{-- Reference End --}}

							{{-- Admin Note --}}
							<div class="form-group">
								<label for="inputAdminNote"
									   class="col-form-label">
									<span class="text-danger">*</span>Admin Note
								</label>
								<div class="input-group">
									<textarea id="inputAdminNote"
											  placeholder=""
											  class="form-control"
											  rows="5">
											</textarea>
								</div>
							</div>
							{{-- Admin Note End --}}
						</div>
					</div>
				</form>
			</div>

			<div class="card-body">
				<div class="d-flex justify-content-between">
					<div class="input-group w-50 mb-3">
						<select type="text"
								class="form-control">
							<option value="">Add Item</option>
						</select>
						<div class="input-group-append">
							<button id="addRowBtn"
									class="btn btn-sm btn-outline-light">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div>
						Show quantity as:
						<label class="custom-control custom-radio custom-control-inline">
							<input type="radio"
								   name="radio-inline"
								   checked=""
								   class="custom-control-input"><span class="custom-control-label">Qty</span>
						</label>
						<label class="custom-control custom-radio custom-control-inline">
							<input type="radio"
								   name="radio-inline"
								   class="custom-control-input"><span class="custom-control-label">Hours</span>
						</label>
						<label class="custom-control custom-radio custom-control-inline">
							<input type="radio"
								   name="radio-inline"
								   class="custom-control-input"><span class="custom-control-label">Qty/Hours</span>
						</label>
					</div>
				</div>
				<div class="table-responsive">
					<table id="myTable" class="table">
						<thead>
							<tr>
								<th>Item</th>
								<th>Description</th>
								<th>Qty</th>
								<th>Rate</th>
								<th>Tax</th>
								<th>Amount</th>
								<th><i class="fa fa-cog"></i></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="input-group">
										<textarea id="inputItem"
												  placeholder="Description"
												  class="form-control"
												  rows="5">
										</textarea>
									</div>
								</td>
								<td>
									<div class="input-group">
										<textarea type="text"
												  id="inputDescription"
												  placeholder="Long Description"
												  class="form-control"
												  rows="5">
										</textarea>
									</div>
								</td>
								<td>
									<div class="input-group">
										<input type="number"
											   id="inputQty"
											   placeholder=""
											   class="form-control">
									</div>
								</td>
								<td>
									<div class="input-group">
										<input type="number"
											   id="inputRate"
											   placeholder=""
											   class="form-control">
									</div>
								</td>
								<td>
									<div class="input-group">
										<select id="user"
												name="discount_type"
												class="form-control"
												required>
											<option value="">16%</option>
										</select>
									</div>
								</td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="d-flex justify-content-end mt-2">
					<button type="submit"
							class="btn btn-primary">Create Credit Note</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
	var addRowButton = document.getElementById('addRowBtn');
	var tableBody = document.querySelector('#myTable tbody');
	
	addRowButton.addEventListener('click', function() {
	// Create a new row
	var newRow = document.createElement('tr');
	
	// Add cells (columns) to the new row
	newRow.innerHTML = `
	<tr>
		<td>
			<div class="input-group">
				<textarea id="inputItem"
						  placeholder="Description"
						  class="form-control"
						  rows="5">
											</textarea>
			</div>
		</td>
		<td>
			<div class="input-group">
				<textarea type="text"
						  id="inputDescription"
						  placeholder="Long Description"
						  class="form-control"
						  rows="5">
											</textarea>
			</div>
		</td>
		<td>
			<div class="input-group">
				<input type="number"
					   id="inputQty"
					   placeholder=""
					   class="form-control">
			</div>
		</td>
		<td>
			<div class="input-group">
				<input type="number"
					   id="inputRate"
					   placeholder=""
					   class="form-control">
			</div>
		</td>
		<td>
			<div class="input-group">
				<select id="user"
						name="discount_type"
						class="form-control"
						required>
					<option value="">16%</option>
				</select>
			</div>
		</td>
		<td></td>
		<td></td>
	</tr>
	`;
	
	// Append the new row to the table body
	tableBody.appendChild(newRow);
	});
	});
</script>
@endsection