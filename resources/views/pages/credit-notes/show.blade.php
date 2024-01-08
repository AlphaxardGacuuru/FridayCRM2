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

{{-- Create Link --}}
<div class="d-flex justify-content-end mb-4">
	<button class="btn btn-secondary me-5"
			onclick="printInvoice()"><i class="fa fa-print"></i> Print</button>
</div>
{{-- Create Link End --}}

<div id="contentToPrint"
	 class="row">
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
						 style="font-size: 4em;">CREDIT NOTE</div>
					<div @class(["p-2
						 text-center
						 text-capitalize", "bg-danger-subtle"=> $creditNote->status == "not_paid",
						"bg-warning-subtle"=> $creditNote->status == "partially_paid",
						"bg-success-subtle" => $creditNote->status == "paid",
						"bg-dark-subtle" => $creditNote->status == "over_paid"
						])>
						@foreach (explode("_", $creditNote->status) as $status)
						{{ $status }}
						@endforeach
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between mb-4">
					<div class="">
						<h5 class="mb-1">Billed To:</h5>
						<div style="color: gray;">{{ $creditNote->user->name }}</div>
						<div style="color: gray;">Phone: {{ $creditNote->user->phone }}</div>
						<div style="color: gray;">{{ $creditNote->user->address }}</div>
					</div>
					<div class="text-end">
						<p class="m-0"
						   style="color: gray;">Invoice No: {{ $creditNote->serial }}</p>
						<p class="m-0"
						   style="color: gray;">Date: {{ $creditNote->date }}</p>
					</div>
				</div>
				<div class="table-responsive-sm">
					<table class="table">
						<thead>
							<tr>
								<th class="center"
									style="background-color: white;">Item</th>
								<th class="text-center"
									style="background-color: white;">Description</th>
								<th class="text-center"
									style="background-color: white;">Qty</th>
								<th class="text-center"
									style="background-color: white;">Rate</th>
								<th class="right text-right"
									style="background-color: white;">Tax</th>
								<th class="right text-right"
									style="background-color: white;">Amount</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($creditNote->items as $item)
							<tr>
								<td class="center"
									style="background-color: white;">{{ $item["item"] }}</td>
								<td class="text-center"
									style="background-color: white;">{{ $item["description"] }}</td>
								<td class="text-center"
									style="background-color: white;">{{ $item["quantity"] }}</td>
								<td class="text-center"
									style="background-color: white;">{{ $item["rate"] }}</td>
								<td class="right text-right"
									style="background-color: white;">{{ $item["tax"] }}</td>
								<td class="right text-right"
									style="background-color: white;">{{ $item["amount"] ? number_format($item["amount"])
									: '-' }}</td>
							</tr>
							@endforeach
							{{-- Total --}}
							<tr>
								<td colspan="4"
									style="background-color: white;"></td>
								<td class="text-center"
									style="background-color: white;">
									<strong class="text-dark">Total Amount</strong>
								</td>
								<td class="text-right"
									style="background-color: white;">
									<strong class="text-dark">
										KES {{ $creditNote->amount ? number_format($creditNote->amount, 2) : '-' }}
									</strong>
								</td>
							</tr>
							{{-- Total End --}}
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