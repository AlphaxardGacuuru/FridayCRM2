@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- end pageheader  -->
<!-- ============================================================== -->
<div class="row">
	<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="card-header p-4">
				<a class="pt-2 d-inline-block"
				   href="index.html">
					<img src="/storage/img/Bulk Main Logo 800x600.png"
						 style="width: 8em; height: auto"
						 loading="lazy"
						 alt=""></a>

				<div class="float-right">
					<h3 class="mb-0">Invoice #{{ $invoice->id }}</h3>
					Date: {{ $invoice->created_at }}
				</div>
			</div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-sm-6">
						<h5 class="mb-3">From:</h5>
						<h3 class="text-dark mb-1">Bulk Agencies Limited</h3>
						<div>370 - 00207</div>
						<div>Namanga, Kenya</div>
						<div>Email: info@bulkagencies.co.ke</div>
						<div>Phone: +254 722 427 629</div>
					</div>
					<div class="col-sm-6">
						<h5 class="mb-3">To:</h5>
						<h3 class="text-dark mb-1">{{ $invoice->user->name }}</h3>
						<div>{{ $invoice->user->address }}</div>
						{{-- <div>Sikeston, MO 63801</div> --}}
						<div>Email: {{ $invoice->email }}</div>
						<div>Phone: {{ $invoice->phone }}</div>
					</div>
				</div>
				<div class="table-responsive-sm">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="center">SN</th>
								<th>Entry No</th>
								<th>Vehicle Reg</th>
								<th class="right">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($items as $item)
							<tr>
								<td class="center">{{ $loop->iteration }}</td>
								<td class="left">{{ $item->entry_number }}</td>
								<td class="left">{{ $item->vehicle_registration }}</td>
								<td class="right">KES {{ $item->total_value ? number_format($item->total_value) : '-' }}
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
									<td class="left">
										<strong class="text-dark">Total</strong>
									</td>
									<td class="right">
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
			<div class="card-footer bg-white">
				<p class="mb-0">2983 Glenview Drive Corpus Christi, TX 78476</p>
			</div>
		</div>
	</div>
</div>
@endsection