@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<!-- ============================================================== -->
		<!-- custom content list  -->
		<!-- ============================================================== -->
		<div class="card">
			<h5 class="card-header">Statements</h5>
			<div class="card-header">
				<form action="{{ route('statements.by.customer.name') }}"
					  method="GET">
					<div class="input-group mb-3">
						<input type="text"
							   placeholder="Search by Customers"
							   name="search"
							   class="form-control"
							   value="{{ old('search') }}">
						<div class="input-group-append">
							<button type="submit"
									class="btn btn-primary">Search</button>
						</div>
					</div>
				</form>
				<div class="d-flex justify-content-end">
					<form id="status-form"
						  action="/statement-by-status"
						  method="GET"
						  class="w-25">
						<select class="custom-select w-100"
								name="status"
								onchange="
								event.preventDefault(); 
								document.getElementById('status-form').submit();
								">
							<option value="pending"
									{{
									app("request")->input("status") == 'pending' ? 'selected' : ''}}>Pending</option>
							<option value="paid"
									{{
									app("request")->input("status") == 'paid' ? 'selected' : '' }}>Paid</option>
						</select>
					</form>
				</div>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th>SN</th>
							<th>Entry No</th>
							<th>Vehicle Reg</th>
							<th>Curr</th>
							<th>Date</th>
							<th>Type</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Balance</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						<tr>
							<th scope="row">{{ $loop->iteration + ($orders->perPage() * ($orders->currentPage() - 1)) }}
							</th>
							<td>{{ $order->entry_number }}</td>
							<td>{{ $order->vehicle_registration }}</td>
							<td>KES</td>
							<td>{{ $order->total_value ? number_format($order->total_value) : '-' }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				{{ $orders->links() }}
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- end custom content list  -->
		<!-- ============================================================== -->
	</div>
	<div class="col-sm-6"></div>
</div>
@endsection