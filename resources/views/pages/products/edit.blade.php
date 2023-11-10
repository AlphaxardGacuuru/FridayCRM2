@extends('layouts.app')

@section('content')
<!-- ============================================================== -->
<!-- basic form  -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Edit Product</h3>
				<a href="/products"
				   class="btn btn-primary">View All</a>
			</div>
			<div class="card-body">
				<form action="/products/{{ $product->id }}"
					  method="POST">
					@csrf
					{{-- Spoof Method --}}
					<input type="hidden"
						   name="_method"
						   value="PUT">
					{{-- Spoof Method End --}}<div class="form-group">
						<label for="name"
							   class="col-form-label">Name</label>
						<input id="name"
							   type="text"
							   name="name"
							   placeholder="{{ $product->name }}"
							   class="form-control"
							   required>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit"
								class="btn btn-primary">Update Product</button>
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