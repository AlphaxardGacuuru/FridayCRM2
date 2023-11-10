@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Create User</h3>
				<a href="/users"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body">
				<form action="/users"
					  method="POST">
					@csrf
					<div class="form-group">
						<label for="name"
							   class="col-form-label">Name</label>
						<input id="name"
							   type="text"
							   name="name"
							   placeholder="John Doe"
							   class="form-control"
							   required>
					</div>
					<div class="form-group">
						<label for="email">Email address</label>
						<input id="email"
							   type="email"
							   name="email"
							   placeholder="name@example.com"
							   class="form-control"
							   required>
						<p>We'll never share your email with anyone else.</p>
					</div>
					<div class="form-group">
						<label for="phone"
							   class="col-form-label">Phone</label>
						<input id="phone"
							   type="tel"
							   name="phone"
							   class="form-control"
							   placeholder="0700123456">
					</div>
					<div class="form-group">
						<label for="reg_no"
							   class="col-form-label">Registration Number</label>
						<input id="reg_no"
							   type="text"
							   name="registration_number"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="kra_pin"
							   class="col-form-label">KRA Pin</label>
						<input id="kra_pin"
							   type="text"
							   name="kra_pin"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="address"
							   class="col-form-label">Address</label>
						<input id="address"
							   type="text"
							   name="address"
							   class="form-control">
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Create User</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- end basic form  -->
<!-- ============================================================== -->
@endsection