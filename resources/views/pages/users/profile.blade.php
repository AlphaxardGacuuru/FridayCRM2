@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Edit Profile</h3>
			</div>
			<div class="card-body">
				<form action="/profile-update"
					  method="POST"
					  enctype="multipart/form-data">
					@csrf
					{{-- Spoof Method --}}
					<input type="hidden"
						   name="_method"
						   value="PUT">
					{{-- Spoof Method End --}}

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label for="inputAvatar"
									   class="col-form-label">Avatar</label>
								{{-- Avatar --}}
								<div class="m-4 text-center">
									<img src="{{ auth()->user()->avatar }}"
										 class="p-2 rounded-circle shadow"
										 style="width: 200px; heigth: 200px;" />
								</div>
								<input id="inputAvatar"
									   type="file"
									   accept="image/*"
									   name="avatar"
									   class="form-control w-75 mx-auto">
								{{-- Avatar End --}}
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label for="inputText3"
									   class="col-form-label">Name</label>
								<input id="inputText3"
									   type="text"
									   name="name"
									   placeholder="{{ auth()->user()->name }}"
									   class="form-control">
							</div>
							<div class="form-group">
								<label for="inputEmail">Email address</label>
								<input id="inputEmail"
									   type="email"
									   name="email"
									   placeholder="{{ auth()->user()->email }}"
									   class="form-control">
							</div>
							<div class="form-group">
								<label for="inputText4"
									   class="col-form-label">Phone</label>
								<input id="inputText4"
									   type="tel"
									   name="phone"
									   class="form-control"
									   placeholder="{{ auth()->user()->phone }}">
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Update Profile</button>
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