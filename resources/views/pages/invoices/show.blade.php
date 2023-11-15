@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- end pageheader  -->
<!-- ============================================================== -->
<div class="row">
	<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card p-5">
			<div class="card-header p-4 border-0">
				<a class="pt-2 d-inline-block"
				   href="index.html">
					<img src="/storage/img/Bulk Main Logo 800x600.png"
						 style="width: 12em; height: auto"
						 loading="lazy"
						 alt=""></a>

				<div class="float-right">
					<h1 class="mb-0">Invoice</h1>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between mb-4">
					<div class="">
						<h5 class="mb-1">Billed To:</h5>
						<div style="color: gray;">{{ $invoice->user->name }}</div>
						<div style="color: gray;">Phone: {{ $invoice->phone }}</div>
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
									style="background-color: white;">(SN)</th>
								<th style="background-color: white;">Entry No</th>
								<th style="background-color: white;">Vehicle Reg</th>
								<th class="right"
									style="background-color: white;">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($items as $item)
							<tr>
								<td class="center"
									style="background-color: white;">{{ $loop->iteration }}</td>
								<td class="left"
									style="background-color: white;">{{ $item->entry_number }}</td>
								<td class="left"
									style="background-color: white;">{{ $item->vehicle_registration }}</td>
								<td class="right"
									style="background-color: white;">KES {{ $item->total_value ?
									number_format($item->total_value) : '-' }}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-lg-4 col-sm-5">
					</div>
					<div class="col-lg-4 col-sm-5 ml-auto">
						<table class="table table-clear">
							<tbody>
								{{-- <tr>
									<td class="left">
										<strong class="text-dark">Subtotal</strong>
									</td>
									<td class="right">$28,809,00</td>
								</tr>
								<tr>
									<td class="left">
										<strong class="text-dark">Discount (20%)</strong>
									</td>
									<td class="right">$5,761,00</td>
								</tr>
								<tr>
									<td class="left">
										<strong class="text-dark">VAT (10%)</strong>
									</td>
									<td class="right">$2,304,00</td>
								</tr> --}}
								<tr>
									<td class="left"
										style="background-color: white;">
										<strong class="text-dark">Total</strong>
									</td>
									<td class="right"
										style="background-color: white;">
										<strong class="text-dark">
											KES {{ $invoice->amount ? number_format($invoice->amount) : '-' }}
										</strong>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card-footer bg-white border-0">
				<h1 class="my-5">Thank you!</h1>

				<div class="d-flex justify-content-between">
					<div>Payment Information</div>
					<div class="text-end">
						<h3 class="text-dark mb-1">Bulk Agencies Limited</h3>
						<div>370 - 00207</div>
						<div>Namanga, Kenya</div>
						<div>Email: info@bulkagencies.co.ke</div>
						<div>Phone: +254 722 427 629</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection