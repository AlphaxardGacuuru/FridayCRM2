@extends('layouts.app')

@section('login')
<div style="
	background: url('/storage/img/logistics.jpg');
  	background-repeat: no-repeat;
  	background-position: center center;
  	background-size: cover;
	">
	<div class="splash-container pt-5">
		<div class="card mt-5">
			<div class="card-header text-center">
				<a href="/">
					<img class="logo-img"
						 src="/storage/img/Bulk Black Logo 800x600.png"
						 style="width: 20em; height: auto"
						 alt="logo">
				</a>
				<span class="splash-description">Please enter your user information.</span>
			</div>
			<div class="card-body">
				<form method="POST"
					  action="{{ route('login') }}">
					@csrf
					<div class="form-group">
						<input id="email"
							   type="text"
							   name="email"
							   class="form-control form-control-lg @error('email') is-invalid @enderror"
							   placeholder="Email"
							   value="{{ old('email') }}"
							   autocomplete="on"
							   required
							   autofocus>

						@error('email')
						<span class="invalid-feedback"
							  role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<input id="password"
							   type="password"
							   name="password"
							   class="form-control form-control-lg @error('password') is-invalid @enderror"
							   placeholder="Password"
							   autocomplete="current-password"
							   required>

						@error('password')
						<span class="invalid-feedback"
							  role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<label class="custom-control custom-checkbox">
							<input class="custom-control-input"
								   type="checkbox"
								   {{
								   old('remember')
								   ? 'checked'
								   : ''
								   }}>
							<span class="custom-control-label">Remember Me</span>
						</label>
					</div>
					<button type="submit"
							class="btn btn-primary btn-lg btn-block">Sign in</button>
				</form>
			</div>
			<div class="card-footer bg-white p-0">
				@if (Route::has('register'))
				<div class="card-footer-item card-footer-item-bordered">
					<a href="#"
					   class="footer-link">Create An Account</a>
				</div>
				@endif
				@if (Route::has('password.request'))
				<div class="card-footer-item card-footer-item-bordered">
					<a href="{{ route('password.request') }}"
					   class="footer-link">Forgot Password</a>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection