@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Edit User</h3>
				<a href="/users"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body">
				<form action="/users/{{ $user->id }}"
					  method="POST">
					@csrf
					{{-- Spoof Method --}}
					<input type="hidden"
						   name="_method"
						   value="PUT">
					{{-- Spoof Method End --}}
					<div class="form-group">
						<label for="inputText3"
							   class="col-form-label">Name</label>
						<input id="inputText3"
							   type="text"
							   name="name"
							   placeholder="{{ $user->name }}"
							   class="form-control">
					</div>
					<div class="form-group">
						<label for="inputEmail">Email address</label>
						<input id="inputEmail"
							   type="email"
							   name="email"
							   placeholder="{{ $user->email }}"
							   class="form-control">
						<p>We'll never share your email with anyone else.</p>
					</div>
					<div class="form-group">
						<label for="inputText4"
							   class="col-form-label">Phone</label>
						<input id="inputText4"
							   type="tel"
							   name="phone"
							   class="form-control"
							   placeholder="{{ $user->phone }}">
					</div>
					<div class="form-group">
						<label for="registration_number"
							   class="col-form-label">Registration Number</label>
						<input id="registration_number"
							   type="text"
							   name="registration_number"
							   class="form-control"
							   placeholder="{{ $user->registration_number }}">
					</div>
					<div class="form-group">
						<label for="kra_pin"
							   class="col-form-label">KRA Pin</label>
						<input id="kra_pin"
							   type="text"
							   name="kra_pin"
							   class="form-control"
							   placeholder="{{ $user->kra_pin }}">
					</div>
					<div class="form-group">
						<label for="address"
							   class="col-form-label">Address</label>
						<input id="address"
							   type="text"
							   name="address"
							   class="form-control"
							   placeholder="{{ $user->address }}">
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Update User</button>
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