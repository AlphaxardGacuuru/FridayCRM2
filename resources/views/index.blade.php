@extends('layouts.app')

@section('content')

<div class="ecommerce-widget">
	<div class="row">
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">Customers</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">{{ $dashboard["users"]["total"] }}</h1>
					</div>
					{{-- Declare User Growth Variable --}}
					@php
					$userGrowth = $dashboard["users"]["growth"];
					@endphp
					{{-- Show Growth --}}
					@if ($userGrowth > 0)
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-up"></i></span>
						<span>{{ $userGrowth }}%</span>
					</div>
					@elseif ($userGrowth == 0)
					<div class="metric-label d-inline-block float-right text-muted font-weight-bold">
						<span>{{ $userGrowth }}%</span>
					</div>
					@else
					<div class="metric-label d-inline-block float-right text-warning font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-down"></i></span>
						<span>{{ $userGrowth }}%</span>
					</div>
					@endif
					{{-- Show Growth End --}}
				</div>
				<div id="sparkline-revenue">
					<div id="spark-user-data"
						 class="d-none">{{ $dashboard["users"]["lastWeek"] }}</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">Orders</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">{{ $dashboard["orders"]["total"] }}</h1>
					</div>
					{{-- Declare User Growth Variable --}}
					@php
					$orderGrowth = $dashboard["orders"]["growth"];
					@endphp
					{{-- Show Growth --}}
					@if ($orderGrowth > 0)
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-up"></i></span>
						<span>{{ $orderGrowth }}%</span>
					</div>
					@elseif ($orderGrowth == 0)
					<div class="metric-label d-inline-block float-right text-muted font-weight-bold">
						<span>{{ $orderGrowth }}%</span>
					</div>
					@else
					<div class="metric-label d-inline-block float-right text-danger font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-down"></i></span>
						<span>{{ $orderGrowth }}%</span>
					</div>
					@endif
					{{-- Show Growth End --}}
				</div>
				<div id="sparkline-revenue2">
					<div id="spark-order-data"
						 class="d-none">{{ $dashboard["orders"]["lastMonth"]["data"] }}</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">Revenue</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1 text-success fs-4">KES {{ $dashboard["revenue"]["total"] }}</h1>
					</div>{{-- Declare User Growth Variable --}}
					@php
					$revenueGrowth = $dashboard["revenue"]["growth"];
					@endphp
					{{-- Show Growth --}}
					@if ($revenueGrowth > 0)
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-up"></i></span>
						<span>{{ $revenueGrowth }}%</span>
					</div>
					@elseif ($revenueGrowth == 0)
					<div class="metric-label d-inline-block float-right text-muted font-weight-bold">
						<span>{{ $revenueGrowth }}%</span>
					</div>
					@else
					<div class="metric-label d-inline-block float-right text-danger font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-down"></i></span>
						<span>{{ $revenueGrowth }}%</span>
					</div>
					@endif
					{{-- Show Growth End --}}
				</div>
				<div id="sparkline-revenue3">
					<div id="spark-revenue-data"
						 class="d-none">{{ $dashboard["revenueLastWeek"]["data"] }}</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="text-muted">Products</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">{{ $dashboard["products"]["total"] }}</h1>
					</div>{{-- Declare User Growth Variable --}}
					@php
					$productGrowth = $dashboard["products"]["growth"];
					@endphp
					{{-- Show Growth --}}
					@if ($productGrowth > 0)
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-up"></i></span>
						<span>{{ $productGrowth }}%</span>
					</div>
					@elseif ($productGrowth == 0)
					<div class="metric-label d-inline-block float-right text-muted font-weight-bold">
						<span>{{ $productGrowth }}%</span>
					</div>
					@else
					<div class="metric-label d-inline-block float-right text-danger font-weight-bold">
						<span><i class="fa fa-fw fa-arrow-down"></i></span>
						<span>{{ $productGrowth }}%</span>
					</div>
					@endif
					{{-- Show Growth End --}}
				</div>
				<div id="sparkline-revenue4">
					<div id="spark-product-data"
						 class="d-none">{{ $dashboard["productsLastWeek"]["data"] }}</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">



		<div class="row">
			{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header"> Product Category</h5>
					<div class="card-body">
						<div class="ct-chart-category ct-golden-section"
							 style="height: 315px;"></div>
						<div class="text-center m-t-40">
							<span class="legend-item mr-3">
								<span class="fa-xs text-primary mr-1 legend-tile"><i
									   class="fa fa-fw fa-square-full "></i></span><span class="legend-text">Man</span>
							</span>
							<span class="legend-item mr-3">
								<span class="fa-xs text-secondary mr-1 legend-tile"><i
									   class="fa fa-fw fa-square-full"></i></span>
								<span class="legend-text">Woman</span>
							</span>
							<span class="legend-item mr-3">
								<span class="fa-xs text-info mr-1 legend-tile"><i
									   class="fa fa-fw fa-square-full"></i></span>
								<span class="legend-text">Accessories</span>
							</span>
						</div>
					</div>
				</div>
			</div> --}}


			<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-header">
						{{-- <div class="float-right">
							<select class="custom-select">
								<option selected>Today</option>
								<option value="1">Weekly</option>
								<option value="2">Monthly</option>
								<option value="3">Yearly</option>
							</select>
						</div> --}}
						<h5 class="mb-0"> Orders per day</h5>
					</div>
					<div class="card-body">
						<div class="ct-chart-product ct-golden-section"
							 style="max-height: 50vh;">
							<div id="bar-labels"
								 class="d-none">{{ $dashboard["orders"]["lastMonth"]["labels"] }}</div>
							<div id="bar-data"
								 class="d-none">{{ $dashboard["orders"]["lastMonth"]["data"] }}</div>
						</div>
					</div>
				</div>
			</div>

			<!-- end product sales  -->

			<div class="col-xl-4 col-lg-12 col-md-4 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header">Top Performing Products</h5>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table no-wrap p-table">
								<thead class="bg-light">
									<tr class="border-0">
										<th class="border-0">
											SN</th>
										<th class="border-0">Name</th>
										<th class="border-0">Orders</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($dashboard["products"]["top"] as $product)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $product->name }}</td>
										<td>{{ $product->orders_count }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<a href="/products"
						   class="btn btn-outline-light float-right">Details</a>
					</div>
				</div>
			</div>
		</div>

		<!-- recent orders  -->

		<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Recent Orders</h5>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table">
							<thead class="bg-light">
								<tr class="border-0">
									<th class="border-0 text-capitalize">SN</th>
									<th class="border-0 text-capitalize">Date</th>
									<th class="border-0 text-capitalize">Vehicle Registration</th>
									<th class="border-0 text-capitalize">Entry Number</th>
									<th class="border-0 text-capitalize">Customer</th>
									<th class="border-0 text-capitalize">Product</th>
									<th class="border-0 text-capitalize">Kra Due</th>
									<th class="border-0 text-capitalize">Kebs Due</th>
									<th class="border-0 text-capitalize">Total Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($dashboard["orders"]["list"] as $order)
								<tr>
									<th scope="row">{{ $loop->iteration }}</th>
									<td>{{ $order->date }}</td>
									<td>{{ $order->vehicle_registration }}</td>
									<td>{{ $order->entry_number }}</td>
									<td>{{ $order->user->name }}</td>
									<td>{{ $order->product->name }}</td>
									<td>{{ $order->kra_due ? number_format($order->kra_due) : '-' }}</td>
									<td>{{ $order->kebs_due ? number_format($order->kebs_due) : '-' }}</td>
									<td>{{ $order->other_charges ? number_format($order->other_charges) : '-' }}
									</td>
									<td>{{ $order->total_value ? number_format($order->total_value) : '-' }}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<a href="/orders"
					   class="btn btn-outline-light float-right">View Details</a>
				</div>
			</div>
		</div>

		<!-- end recent orders  -->




		<!-- customer acquistion  -->

		{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Customer Acquisition</h5>
				<div class="card-body">
					<div class="ct-chart ct-golden-section"
						 style="height: 354px;"></div>
					<div class="text-center">
						<span class="legend-item mr-2">
							<span class="fa-xs text-primary mr-1 legend-tile"><i
								   class="fa fa-fw fa-square-full"></i></span>
							<span class="legend-text">Returning</span>
						</span>
						<span class="legend-item mr-2">

							<span class="fa-xs text-secondary mr-1 legend-tile"><i
								   class="fa fa-fw fa-square-full"></i></span>
							<span class="legend-text">First Time</span>
						</span>
					</div>
				</div>
			</div>
		</div> --}}

		<!-- end customer acquistion  -->

	</div>

	{{-- <div class="row">

		<!-- sales  -->

		<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
					<h5 class="text-muted">Sales</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">KES 12099</h1>
					</div>
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span class="icon-circle-small icon-box-xs text-success bg-success-light"><i
							   class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span>
					</div>
				</div>
			</div>
		</div>

		<!-- end sales  -->


		<!-- new customer  -->

		<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
					<h5 class="text-muted">New Customer</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">1245</h1>
					</div>
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span class="icon-circle-small icon-box-xs text-success bg-success-light"><i
							   class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">10%</span>
					</div>
				</div>
			</div>
		</div>

		<!-- end new customer  -->


		<!-- visitor  -->

		<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
					<h5 class="text-muted">Visitor</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">13000</h1>
					</div>
					<div class="metric-label d-inline-block float-right text-success font-weight-bold">
						<span class="icon-circle-small icon-box-xs text-success bg-success-light"><i
							   class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5%</span>
					</div>
				</div>
			</div>
		</div>

		<!-- end visitor  -->


		<!-- total orders  -->

		<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
					<h5 class="text-muted">Total Orders</h5>
					<div class="metric-value d-inline-block">
						<h1 class="mb-1">1340</h1>
					</div>
					<div class="metric-label d-inline-block float-right text-danger font-weight-bold">
						<span class="icon-circle-small icon-box-xs text-danger bg-danger-light bg-danger-light "><i
							   class="fa fa-fw fa-arrow-down"></i></span><span class="ml-1">4%</span>
					</div>
				</div>
			</div>
		</div>

		<!-- end total orders  -->

	</div> --}}
	<div class="row">
		{{-- <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Revenue by Category</h5>
				<div class="card-body">
					<div id="c3chart_category"
						 style="height: 420px;"></div>
				</div>
			</div>
		</div> --}}

		{{-- <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"> Total Revenue</h5>
				<div class="card-body">
					<div id="morris_totalrevenue"></div>
				</div>
				<div class="card-footer">
					<p class="display-7 font-weight-bold"><span class="text-primary d-inline-block">KES
							26,000</span><span class="text-success float-right">+9.45%</span></p>
				</div>
			</div>
		</div> --}}
	</div>
	{{-- <div class="row">
		<div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">

			<!-- social source  -->

			<div class="card">
				<h5 class="card-header"> Sales By Social Source</h5>
				<div class="card-body p-0">
					<ul class="social-sales list-group list-group-flush">
						<li class="list-group-item social-sales-content"><span
								  class="social-sales-icon-circle facebook-bgcolor mr-2"><i
								   class="fab fa-facebook-f"></i></span><span
								  class="social-sales-name">Facebook</span><span
								  class="social-sales-count text-dark">120 Sales</span>
						</li>
						<li class="list-group-item social-sales-content"><span
								  class="social-sales-icon-circle twitter-bgcolor mr-2"><i
								   class="fab fa-twitter"></i></span><span class="social-sales-name">Twitter</span><span
								  class="social-sales-count text-dark">99 Sales</span>
						</li>
						<li class="list-group-item social-sales-content"><span
								  class="social-sales-icon-circle instagram-bgcolor mr-2"><i
								   class="fab fa-instagram"></i></span><span
								  class="social-sales-name">Instagram</span><span
								  class="social-sales-count text-dark">76 Sales</span>
						</li>
						<li class="list-group-item social-sales-content"><span
								  class="social-sales-icon-circle pinterest-bgcolor mr-2"><i
								   class="fab fa-pinterest-p"></i></span><span
								  class="social-sales-name">Pinterest</span><span
								  class="social-sales-count text-dark">56 Sales</span>
						</li>
						<li class="list-group-item social-sales-content"><span
								  class="social-sales-icon-circle googleplus-bgcolor mr-2"><i
								   class="fab fa-google-plus-g"></i></span><span class="social-sales-name">Google
								Plus</span><span class="social-sales-count text-dark">36 Sales</span>
						</li>
					</ul>
				</div>
				<div class="card-footer text-center">
					<a href="#"
					   class="btn-primary-link">View Details</a>
				</div>
			</div>

			<!-- end social source  -->

		</div>
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">

			<!-- sales traffice source  -->

			<div class="card">
				<h5 class="card-header"> Sales By Traffic Source</h5>
				<div class="card-body p-0">
					<ul class="traffic-sales list-group list-group-flush">
						<li class="traffic-sales-content list-group-item "><span
								  class="traffic-sales-name">Direct</span><span class="traffic-sales-amount">KES
								4000.00 <span
									  class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i
									   class="fa fa-fw fa-arrow-up"></i></span><span
									  class="ml-1 text-success">5.86%</span></span>
						</li>
						<li class="traffic-sales-content list-group-item"><span class="traffic-sales-name">Search<span
									  class="traffic-sales-amount">KES
									3123.00 <span
										  class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i
										   class="fa fa-fw fa-arrow-up"></i></span><span
										  class="ml-1 text-success">5.86%</span></span>
							</span>
						</li>
						<li class="traffic-sales-content list-group-item"><span class="traffic-sales-name">Social<span
									  class="traffic-sales-amount ">KES
									3099.00 <span
										  class="icon-circle-small icon-box-xs text-success ml-4 bg-success-light"><i
										   class="fa fa-fw fa-arrow-up"></i></span><span
										  class="ml-1 text-success">5.86%</span></span>
							</span>
						</li>
						<li class="traffic-sales-content list-group-item"><span
								  class="traffic-sales-name">Referrals<span class="traffic-sales-amount ">KES
									2220.00 <span
										  class="icon-circle-small icon-box-xs text-danger ml-4 bg-danger-light"><i
										   class="fa fa-fw fa-arrow-down"></i></span><span
										  class="ml-1 text-danger">4.02%</span></span>
							</span>
						</li>
						<li class="traffic-sales-content list-group-item "><span class="traffic-sales-name">Email<span
									  class="traffic-sales-amount">KES 1567.00
									<span class="icon-circle-small icon-box-xs text-danger ml-4 bg-danger-light"><i
										   class="fa fa-fw fa-arrow-down"></i></span><span
										  class="ml-1 text-danger">3.86%</span></span>
							</span>
						</li>
					</ul>
				</div>
				<div class="card-footer text-center">
					<a href="#"
					   class="btn-primary-link">View Details</a>
				</div>
			</div>
		</div>

		<!-- end sales traffice source  -->


		<!-- sales traffic country source  -->

		<div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">Sales By Country Traffic Source</h5>
				<div class="card-body p-0">
					<ul class="country-sales list-group list-group-flush">
						<li class="country-sales-content list-group-item"><span class="mr-2"><i
								   class="flag-icon flag-icon-us"
								   title="us"
								   id="us"></i> </span>
							<span class="">United States</span><span class="float-right text-dark">78%</span>
						</li>
						<li class="list-group-item country-sales-content"><span class="mr-2"><i
								   class="flag-icon flag-icon-ca"
								   title="ca"
								   id="ca"></i></span><span class="">Canada</span><span
								  class="float-right text-dark">7%</span>
						</li>
						<li class="list-group-item country-sales-content"><span class="mr-2"><i
								   class="flag-icon flag-icon-ru"
								   title="ru"
								   id="ru"></i></span><span class="">Russia</span><span
								  class="float-right text-dark">4%</span>
						</li>
						<li class="list-group-item country-sales-content"><span class=" mr-2"><i
								   class="flag-icon flag-icon-in"
								   title="in"
								   id="in"></i></span><span class="">India</span><span
								  class="float-right text-dark">12%</span>
						</li>
						<li class="list-group-item country-sales-content"><span class=" mr-2"><i
								   class="flag-icon flag-icon-fr"
								   title="fr"
								   id="fr"></i></span><span class="">France</span><span
								  class="float-right text-dark">16%</span>
						</li>
					</ul>
				</div>
				<div class="card-footer text-center">
					<a href="#"
					   class="btn-primary-link">View Details</a>
				</div>
			</div>
		</div>

		<!-- end sales traffice country source  -->

	</div> --}}
</div>
@endsection