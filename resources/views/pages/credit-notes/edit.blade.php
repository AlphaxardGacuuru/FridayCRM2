@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Edit Credit Note</h3>
				<a href="/credit-notes"
				   class="btn btn-primary">View All</a>
			</div>

			<form action="/credit-notes/{{ $creditNote->id }}"
				  method="POST">
				@csrf

				{{-- Spoof PUT method --}}
				<input type="hidden"
					   name="_method"
					   value="PUT">
				{{-- Spoof PUT method End --}}

				<div class="card-body border-bottom">
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
									<option value="{{ $user->id}}"
											{{
											$creditNote->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
									</option>
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
										   value="{{ $creditNote->dateUnformated }}"
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
												   name="serial"
												   placeholder="{{ $creditNote->serial }}"
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
										<option value="no_discount">No Discount</option>
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
										   name="reference"
										   placeholder="{{ $creditNote->reference }}"
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
								<div class='input-group'>
									<textarea id='inputAdminNote'
											  name='admin_note'
											  placeholder='{{ $creditNote->admin_note }}'
											  value='{{ $creditNote->admin_note }}'
											  class='form-control'
											  rows='5'></textarea>
								</div>
							</div>
							{{-- Admin Note End --}}
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="d-flex justify-content-between flex-wrap">
						<div class="input-group col-sm-12 col-lg-6 mb-3">
							<select type="text"
									class="form-control">
								<option value="">Add Item</option>
							</select>
							<div class="input-group-append">
								<button id="addRowBtn"
										type="button"
										class="btn btn-sm btn-outline-light"
										onclick="addRow()">
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="text-end m-1 flex-grow-1">
							Show quantity as:
						</div>
						<div>
							<label class="custom-control custom-radio custom-control-inline">
								<input type="radio"
									   name="quantity_as"
									   value="as_quantity"
									   class="custom-control-input"
									   {{
									   $creditNote->quantity_as == "as_quantity" ? 'checked' : '' }}>
								<span class="custom-control-label">Qty</span>
							</label>
							<label class="custom-control custom-radio custom-control-inline">
								<input type="radio"
									   name="quantity_as"
									   value="as_hours"
									   class="custom-control-input"
									   {{
									   $creditNote->quantity_as == "as_hours" ? 'checked' : '' }}>
								<span class="custom-control-label">Hours</span>
							</label>
							<label class="custom-control custom-radio custom-control-inline">
								<input type="radio"
									   name="quantity_as"
									   value="as_quantity_hours"
									   class="custom-control-input"
									   {{
									   $creditNote->quantity_as == "as_quantity_hours" ? 'checked' : '' }}>
								<span class="custom-control-label">Qty/Hours</span>
							</label>
						</div>
					</div>
					<div class="table-responsive">
						<table id="myTable"
							   class="table">
							<thead>
								<tr>
									<th>Item</th>
									<th>Description</th>
									<th>Qty</th>
									<th>Rate</th>
									<th>Tax</th>
									<th>Amount</th>
									<th><i class="fa fa-cog"></i></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($creditNote->items as $item)
								<tr>
									<td>
										<div class='input-group'>
											<textarea id='inputItem'
													  name='item[]'
													  placeholder='{{ $item["item"] }}'
													  class='form-control'
													  rows='5'>
													 {{ $item["item"] }}
											</textarea>
										</div>
									</td>
									<td>
										<div class='input-group'>
											<textarea type='text'
													  id='inputDescription'
													  name='description[]'
													  placeholder='{{ $item["description"] }}'
													  class='form-control'
													  rows='5'>
													 {{ $item["description"] }}
											</textarea>
										</div>
									</td>
									<td>
										<div class='input-group'>
											<input type='number'
												   id='inputQty'
												   name='quantity[]'
												   placeholder='{{ $item["quantity"] }}'
												   value='{{ $item["quantity"] }}'
												   class='form-control'>
										</div>
									</td>
									<td>
										<div class='input-group'>
											<input type='number'
												   id='inputRate'
												   name='rate[]'
												   placeholder='{{ $item["rate"] }}'
												   value='{{ $item["rate"] }}'
												   class='form-control'>
										</div>
									</td>
									<td>
										<div class='input-group'>
											<select id='user'
													name='tax[]'
													class='form-control'
													required>
												<option value='16'>16%</option>
											</select>
										</div>
									</td>
									<td>
										<div class='input-group'>
											<input type='number'
												   id='inputRate'
												   name='amount[]'
												   placeholder='{{ $item["amount"] }}'
												   value='{{ $item["amount"] }}'
												   class='form-control'
												   required>
										</div>
									</td>
									<td></td>
									<td>
										<i class='fa fa-window-close fs-4'
										   style='cursor: pointer'
										   onclick='
										   var row = this.parentNode.parentNode
											row.parentNode.removeChild(row)
										'></i>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="d-flex justify-content-end mt-2">
						<button type="submit"
								class="btn btn-primary">Update Credit Note</button>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>

<script>
	function addRow() {
		var table = document
			.getElementById("myTable")
			.getElementsByTagName("tbody")[0]

		// Create a new row
		var newRow = table.insertRow()

		// Insert cells (columns) in the new row
		var cell0 = newRow.insertCell(0)
		var cell1 = newRow.insertCell(1)
		var cell2 = newRow.insertCell(2)
		var cell3 = newRow.insertCell(3)
		var cell4 = newRow.insertCell(4)
		var cell5 = newRow.insertCell(5)
		var cell6 = newRow.insertCell(6)
		var cell7 = newRow.insertCell(7)

		// Set cell content - adjust as needed
		cell0.innerHTML = "<div class='input-group'><textarea id='inputItem' name='item[]' placeholder='Description'  class='form-control'  rows='5'></textarea></div>"
		cell1.innerHTML = "<div class='input-group'><textarea type='text' id='inputDescription' name='description[]' placeholder='Long Description' class='form-control' rows='5'></textarea></div>"
		cell2.innerHTML = "<div class='input-group'><input type='number' id='inputQty' name='quantity[]' placeholder='' class='form-control'></div>"
		cell3.innerHTML = "<div class='input-group'><input type='number' id='inputRate' name='rate[]' placeholder='' class='form-control'></div>"
		cell4.innerHTML = "<div class='input-group'><select id='user' name='tax[]' class='form-control' required><option value='16'>16%</option></select></div>"
		cell5.innerHTML = "<div class='input-group'><input type='number' id='inputRate' name='amount[]' placeholder='' class='form-control' required></div>"
		cell6.innerHTML = ""

		// Create a delete button (x icon)
		var deleteButton = document.createElement("div")
		
		deleteButton.innerHTML = "<i class='fa fa-window-close fs-4' style='cursor: pointer'></i>"
		deleteButton.onclick = function () {
			var row = this.parentNode.parentNode
			row.parentNode.removeChild(row)
		}

		// Insert delete button into the third cell
		cell7.appendChild(deleteButton)
	}
</script>
@endsection