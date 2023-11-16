@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Invoices</h3>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">SN</th>
							<th scope="col">Invoice No</th>
							<th scope="col">Customer</th>
							<th scope="col">Amount</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($invoices as $invoice)
						<tr>
							<th scope="row">{{ $loop->iteration + ($invoices->perPage() * ($invoices->currentPage() -
								1)) }}</th>
							<td>{{ $invoice->id }}</td>
							<td>{{ $invoice->user->name }}</td>
							<td>{{ $invoice->amount ? number_format($invoice->amount) : '-' }}</td>
							<td>
								{{-- Show Invoice --}}
								<a href="/invoices/{{ $invoice->id }}"
								   class="btn btn-sm btn-primary me-1">
									<i class="fa fa-eye"></i>
								</a>
								{{-- Show Invoice End --}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				{{ $invoices->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection