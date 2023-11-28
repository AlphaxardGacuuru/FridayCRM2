@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		{{-- Data --}}
		<div class="card p-4"
			 style="color: gray;">
			<div class="d-flex justify-content-between flex-wrap">
				{{-- Orders Total --}}
				<div class="d-flex justify-content-between align-items-center mx-4 flex-grow-1 border-end">
					<div>
						<span class="fs-4">{{ number_format($ordersTotal) }}</span>
						<h4 style="color: gray;">Total Orders</h4>
					</div>
					<div class="pe-4"><i class="fa fa-file-alt fs-1"></i></div>
				</div>
				{{-- Orders Total End --}}
				{{-- Invoices Sum --}}
				<div class="d-flex justify-content-between align-items-center mx-4 flex-grow-1 border-end">
					<div>
						KES <span class="fs-4">{{ number_format($invoicesSum) }}</span>
						<h4 style="color: gray;">Total Invoices</h4>
					</div>
					<div class="pe-4"><i class="fa fa-dollar-sign fs-1"></i></div>
				</div>
				{{-- Invoices Sum End --}}
				{{-- Payments Sum --}}
				<div class="d-flex justify-content-between align-items-center mx-4 flex-grow-1">
					<div>
						KES <span class="fs-4">{{ number_format($paymentsSum) }}</span>
						<h4 style="color: gray;">Total Payments</h4>
					</div>
					<div><i class="fa fa-credit-card fs-1"></i></div>
				</div>
				{{-- Payments Sum End --}}
			</div>
		</div>
		{{-- Data End --}}

		{{-- Filters --}}
		<div class="card p-4"
			 style="color: gray;">
			<form action="/reports">
				<div class="d-flex flex-wrap">
					{{-- Date --}}
					<div class="flex-grow-1 me-2 mb-2">
						<input id=""
							   name="daterange"
							   type="text"
							   value="{{ $request->input('daterange') }}"
							   class="form-control w-100" />
					</div>
					{{-- Date End --}}
					<div class="flex-grow-1 me-2 mb-2">
						<select id=""
								name="user_id"
								class="form-control">
							<option value="">Select Customer</option>
							@foreach ($users as $user)
							<option value="{{ $user->id }}"
									{{
									$request->input('user_id') == $user->id ? 'selected' : ''}}>
								{{ $user->name }}
							</option>
							@endforeach
						</select>
					</div>
					{{-- Customer End --}}
					{{-- Search --}}
					<div class="">
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
	</div>

	{{-- Create Link --}}
	<div class="d-flex justify-content-end mb-4">
		<button class="btn btn-secondary"
				onclick="printInvoice()"><i class="fa fa-print"></i> Print</button>
	</div>
	{{-- Create Link End --}}

	<div id="contentToPrint"
		 class="row w-100">
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
							 style="font-size: 4em;">REPORT</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">SN</th>
										<th scope="col">Customer</th>
										<th scope="col">Type</th>
										<th scope="col">Amount</th>
										<th scope="col">Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($reports as $report)
									<tr>
										<td scope="row">
											{{ $loop->iteration }}
										</td>
										<td>{{ $report->user->name }}</td>
										<td><span @class(['py-2
												  px-4', 'bg-secondary-subtle'=> $report->type == 'Invoice',
												'bg-success-subtle'=> $report->type == 'Payment',
												'bg-primary-subtle'=> $report->type == 'Order'
												])>
												{{ $report->type }}
											</span>
										</td>
										<td>{{ $report->total ? number_format($report->total) : '-' }}</td>
										<td>{{ $report->date }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="card-footer bg-white border-0">
					<div class="d-flex justify-content-end">
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

	<script>
		function printInvoice() {
	var contentToPrint = document.getElementById('contentToPrint').innerHTML;
	var originalBody = document.body.innerHTML;
	
	document.body.innerHTML = contentToPrint;
	
	window.print();
	
	document.body.innerHTML = originalBody;
	}
	</script>
	@endsection