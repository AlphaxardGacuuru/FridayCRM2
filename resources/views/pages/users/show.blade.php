@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- influencer profile  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card influencer-profile-data">
			<div class="card-body">
				<div class="row">
					{{-- <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
						<div class="text-center">
							<img src="assets/images/avatar-1.jpg"
								 alt="User Avatar"
								 class="rounded-circle user-avatar-xxl">
						</div>
					</div> --}}
					<div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
						<div class="user-avatar-info">
							<div class="m-b-20">
								<div class="user-avatar-name">
									<h2 class="mb-1">{{ $user->name }}</h2>
								</div>
								<div class="rating-star  d-inline-block invisible">
									<i class="fa fa-fw fa-star"></i>
									<i class="fa fa-fw fa-star"></i>
									<i class="fa fa-fw fa-star"></i>
									<i class="fa fa-fw fa-star"></i>
									<i class="fa fa-fw fa-star"></i>
									<p class="d-inline-block text-dark">14 Reviews </p>
								</div>
							</div>
							<!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
							<div class="user-avatar-address">
								<p class="border-bottom pb-3">
									<span class="d-xl-inline-block d-block mb-2">
										<i class="fa fa-map-marker-alt mr-2 text-primary "></i>
										{{ $user->address }}
									</span>
									<span class="mb-2 ml-xl-4 d-xl-inline-block d-block">
										{{ $user->created_at }}
									</span>
									<a href="/users/{{ $user->id }}/edit"
									   class="btn btn-sm btn-primary ms-2">
										<i class="fa fa-edit"></i>
									</a>

									{{-- Button trigger modal --}}
									<button type="button"
											class="btn btn-sm text-white"
											style="background-color: gray"
											data-bs-toggle="modal"
											data-bs-target="#deleteModal{{ $user->id }}">
										<i class="fa fa-trash"></i>
									</button>
								</p>
								{{-- Confirm Delete Modal End --}}
								<div class="modal fade"
									 id="deleteModal{{ $user->id }}"
									 tabIndex="-1"
									 aria-labelledby="deleteModalLabel"
									 aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h1 id="deleteModalLabel"
													class="modal-title fs-5 text-danger">
													Delete User
												</h1>
												<button type="button"
														class="btn-close"
														data-bs-dismiss="modal"
														aria-label="Close"></button>
											</div>
											<div class="modal-body text-wrap">
												Are you sure you want to delete {{ $user->name }}.
												This process is irreversible.
											</div>
											<div class="modal-footer justify-content-between">
												<button type="button"
														class="btn btn-light"
														data-bs-dismiss="modal">
													Close
												</button>
												<button type="button"
														class="btn btn-danger text-white"
														data-bs-dismiss="modal"
														onclick="event.preventDefault();
																							        document.getElementById('deleteForm{{ $user->id }}').submit();">
													Delete
												</button>
												<form id="deleteForm{{ $user->id }}"
													  action="/users/{{ $user->id }}"
													  method="POST"
													  style="display: none;">
													<input type="hidden"
														   name="_method"
														   value="DELETE">
													@csrf
												</form>
											</div>
										</div>
									</div>
								</div>
								{{-- Confirm Delete Modal End --}}
								<div class="mt-3">
									<a href="#"
									   class="badge badge-light mr-1">{{ $user->email }}</a>
									<a href="#"
									   class="badge badge-light mr-1">{{ $user->phone }}</a>
									<a href="#"
									   class="badge badge-light">{{ $user->kra_pin }}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			{{-- <div class="border-top user-social-box">
				<div class="user-social-media d-xl-inline-block"><span class="mr-2 twitter-color">
						<i class="fab fa-twitter-square"></i></span><span>13,291</span></div>
				<div class="user-social-media d-xl-inline-block"><span class="mr-2  pinterest-color"> <i
						   class="fab fa-pinterest-square"></i></span><span>84,019</span></div>
				<div class="user-social-media d-xl-inline-block"><span class="mr-2 instagram-color">
						<i class="fab fa-instagram"></i></span><span>12,300</span></div>
				<div class="user-social-media d-xl-inline-block"><span class="mr-2  facebook-color">
						<i class="fab fa-facebook-square "></i></span><span>92,920</span></div>
				<div class="user-social-media d-xl-inline-block "><span class="mr-2 medium-color">
						<i class="fab fa-medium"></i></span><span>291</span></div>
				<div class="user-social-media d-xl-inline-block"><span class="mr-2 youtube-color">
						<i class="fab fa-youtube"></i></span><span>1291</span></div>
			</div> --}}
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- end influencer profile  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- widgets   -->
<!-- ============================================================== -->
<div class="row">
	<!-- ============================================================== -->
	<!-- four widgets   -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- total views   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card">
			<div class="card-body">
				<div class="d-inline-block">
					<h5 class="text-muted">Total Orders</h5>
					<h2 class="mb-0"> {{ $user->totalOrders }}</h2>
				</div>
				<div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
					<i class="fa fa-eye fa-fw fa-sm text-info"></i>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end total views   -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- total followers   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card">
			<div class="card-body">
				<div class="d-inline-block">
					<h5 class="text-muted">Invoice Arears</h5>
					<h2 class="mb-0"> {{ $user->invoiceArears }}</h2>
				</div>
				<div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
					<i class="fa fa-user fa-fw fa-sm text-primary"></i>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end total followers   -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- partnerships   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card">
			<div class="card-body">
				<div class="d-inline-block">
					<h5 class="text-muted">Total Orders Today</h5>
					<h2 class="mb-0">{{ $user->totalOrdersToday }}</h2>
				</div>
				<div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
					<i class="fa fa-handshake fa-fw fa-sm text-secondary"></i>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end partnerships   -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- total earned   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card">
			<div class="card-body">
				<div class="d-inline-block">
					<h5 class="text-muted">Total Paid</h5>
					<h2 class="mb-0"> {{ number_format($user->totalOrdersPaid) }}</h2>
				</div>
				<div class="float-right icon-circle-medium  icon-box-lg  bg-brand-light mt-1">
					<i class="fa fa-money-bill-alt fa-fw fa-sm text-brand"></i>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end total earned   -->
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end widgets   -->
<!-- ============================================================== -->
<div class="row">
	<!-- ============================================================== -->
	<!-- followers by gender   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card">
			<h5 class="card-header">Followers by Gender</h5>
			<div class="card-body">
				<div id="gender_donut"
					 style="height: 230px;"></div>
			</div>
			<div class="card-footer p-0 bg-white d-flex">
				<div class="card-footer-item card-footer-item-bordered w-50">
					<h2 class="mb-0"> 60% </h2>
					<p>Female </p>
				</div>
				<div class="card-footer-item card-footer-item-bordered">
					<h2 class="mb-0">40% </h2>
					<p>Male </p>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end followers by gender  -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- followers by age   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card">
			<h5 class="card-header">Followers by Age</h5>
			<div class="card-body">
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">15 - 20</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 45%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">20 - 25</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 55%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">25 - 30</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 65%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">30 - 35</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 35%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">35 - 40</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 21%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">45 - 50</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 85%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="d-inline-block">
						<h4 class="mb-0">50 - 55</h4>
					</div>
					<div class="progress mt-2 float-right progress-md">
						<div class="progress-bar bg-secondary"
							 role="progressbar"
							 style="width: 25%;"
							 aria-valuenow="65"
							 aria-valuemin="0"
							 aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end followers by age   -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- followers by locations   -->
	<!-- ============================================================== -->
	{{-- <div class="col-xl-5 col-lg-12 col-md-6 col-sm-12 col-12">
		<div class="card">
			<h5 class="card-header">Top Folllowes by Locations </h5>
			<div class="card-body">
				<canvas id="chartjs_bar_horizontal"></canvas>
			</div>
		</div>
	</div> --}}
	<!-- ============================================================== -->
	<!-- end followers by locations  -->
	<!-- ============================================================== -->
</div>
<div class="row">
	<!-- ============================================================== -->
	<!-- campaign activities   -->
	<!-- ============================================================== -->
	<div class="col-lg-12">
		<div class="section-block">
			<h3 class="section-title">Recent Orders</h3>
		</div>
		<div class="card">
			<div class="campaign-table table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col"
								class="text-uppercase">Entry No</th>
							<th scope="col"
								class="text-uppercase">Vehicle Reg</th>
							<th scope="col"
								class="text-uppercase">CURR</th>
							<th scope="col"
								class="text-uppercase">KRA Due</th>
							<th scope="col"
								class="text-uppercase">KEBS Due</th>
							<th scope="col"
								class="text-uppercase">Other Charges</th>
							<th scope="col"
								class="text-uppercase">Total Value</th>
							<th scope="col"
								class="text-uppercase">Status</th>
							<th scope="col"
								class="text-uppercase">Date</th>
							<th scope="col"
								class="text-uppercase">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						<tr>
							<th scope="row">{{ $loop->iteration }}</th>
							<td>{{ $order->entry_number }}</td>
							<td>{{ $order->vehicle_registration }}</td>
							<td>KES</td>
							<td>{{ number_format($order->kra_due) }}</td>
							<td>{{ number_format($order->kebs_due) }}</td>
							<td>{{ number_format($order->other_charges) }}</td>
							<td>{{ number_format($order->total_value) }}</td>
							<td>
								<span @class(['py-2
									  px-4
									  text-capitalize'
									  , 'bg-warning-subtle'=> $order->status == 'pending'
									, 'bg-success-subtle'=> $order->status == 'paid'
									])>
									{{ $order->status }}
								</span>
							</td>
							<td>{{ $order->date }}</td>
							<td>
								<div class="d-flex">
									<a href="/orders/{{ $order->id }}/edit"
									   class="btn btn-sm btn-primary">
										<i class="fa fa-edit"></i>
									</a>
									<div class="mx-1">
										{{-- Confirm Delete Modal End --}}
										<div class="modal fade"
											 id="deleteModal{{ $order->id }}"
											 tabIndex="-1"
											 aria-labelledby="deleteModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h1 id="deleteModalLabel"
															class="modal-title fs-5 text-danger">
															Delete Club
														</h1>
														<button type="button"
																class="btn-close"
																data-bs-dismiss="modal"
																aria-label="Close"></button>
													</div>
													<div class="modal-body text-wrap">
														Are you sure you want to delete Order.
														This process is irreversible.
													</div>
													<div class="modal-footer justify-content-between">
														<button type="button"
																class="btn btn-light"
																data-bs-dismiss="modal">
															Close
														</button>
														<button type="button"
																class="btn btn-danger text-white"
																data-bs-dismiss="modal"
																onclick="event.preventDefault();
													                                                     document.getElementById('deleteForm{{ $order->id }}').submit();">
															Delete
														</button>
														<form id="deleteForm{{ $order->id }}"
															  action="/orders/{{ $order->id }}"
															  method="POST"
															  style="display: none;">
															<input type="hidden"
																   name="_method"
																   value="DELETE">
															@csrf
														</form>
													</div>
												</div>
											</div>
										</div>
										{{-- Confirm Delete Modal End --}}

										{{-- Button trigger modal --}}
										<button type="button"
												class="btn btn-sm text-white"
												style="background-color: gray"
												data-bs-toggle="modal"
												data-bs-target="#deleteModal{{ $order->id }}">
											<i class="fa fa-trash"></i>
										</button>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				{{ $orders->links() }}
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- end campaign activities   -->
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- recommended campaigns   -->
<!-- ============================================================== -->
{{-- <div class="row">
	<div class="col-lg-12">
		<div class="section-block">
			<h3 class="section-title">Recommended Campaigns</h3>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card campaign-card text-center">
			<div class="card-body">
				<div class="campaign-img"><img src="assets/images/dribbble.png"
						 alt="user"
						 class="user-avatar-xl"></div>
				<div class="campaign-info">
					<h3 class="mb-1">Campaigns Name</h3>
					<p class="mb-3">Vestibulum porttitor laoreet faucibus.</p>
					<p class="mb-1">Min, Views:<span class="text-dark font-medium ml-2">2,50,000</span></p>
					<p>Payout: <span class="text-dark font-medium ml-2">$22</span></p>
					<a href="#"><i class="fab fa-twitter-square fa-sm twitter-color"></i> </a><a href="#"><i
						   class="fab fa-snapchat-square fa-sm snapchat-color"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card campaign-card text-center">
			<div class="card-body">
				<div class="campaign-img"><img src="assets/images/github.png"
						 alt="user"
						 class=" user-avatar-xl"></div>
				<div class="campaign-info">
					<h3 class="mb-1">Campaigns Name</h3>
					<p class="mb-3">Lorem ipsum dolor sit ament</p>
					<p class="mb-1">Min, Views:<span class="text-dark font-medium ml-2">1,00,000</span></p>
					<p>Payout: <span class="text-dark font-medium ml-2">$28</span></p>
					<a href="#"><i class="fab fa-instagram fa-sm instagram-color"></i> </a><a href="#"><i
						   class="fab fa-facebook-square fa-sm facebook-color"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card campaign-card text-center">
			<div class="card-body">
				<div class="campaign-img"><img src="assets/images/slack.png"
						 alt="user"
						 class="user-avatar-xl"></div>
				<div class="campaign-info">
					<h3 class="mb-1">Campaigns Name</h3>
					<p class="mb-3">Maecenas mattis tempor libero pretium.</p>
					<p class="mb-1">Min, Views:<span class="text-dark font-medium ml-2">3,80,000</span></p>
					<p>Payout: <span class="text-dark font-medium ml-2">$36</span></p>
					<a href="#"><i class="fab fa-facebook-square fa-sm facebook-color"></i> </a><a href="#"><i
						   class="fab fa-snapchat-square fa-sm snapchat-color"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
		<div class="card campaign-card text-center">
			<div class="card-body">
				<div class="campaign-img"><img src="assets/images/mail_chimp.png"
						 alt="user"
						 class="user-avatar-xl"></div>
				<div class="campaign-info">
					<h3 class="mb-1">Campaigns Name</h3>
					<p class="mb-3">Proin vitae lacinia leo</p>
					<p class="mb-1">Min, Views:<span class="text-dark font-medium ml-2">4,50,000</span></p>
					<p>Payout: <span class="text-dark font-medium ml-2">$57</span></p>
					<a href="#"><i class="fab fa-twitter-square fa-sm twitter-color"></i> </a><a href="#"><i
						   class="fab fa-snapchat-square fa-sm snapchat-color"></i></a>
					<a href="#"><i class="fab fa-facebook-square fa-sm facebook-color"></i></a>
				</div>
			</div>
		</div>
	</div>
</div> --}}
<!-- ============================================================== -->
<!-- end recommended campaigns   -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- end content  -->
<!-- ============================================================== -->
@endsection