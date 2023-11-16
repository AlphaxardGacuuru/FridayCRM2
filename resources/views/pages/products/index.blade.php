@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Products</h3>
				<a href="/products/create"
				   class="btn btn-primary"><i class="fa fa-dollar-sign"></i> Create</a>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">SN</th>
							<th scope="col">Name</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($products as $product)
						<tr>
							<th scope="row">{{ $loop->iteration + ($products->perPage() * ($products->currentPage() -
								1)) }}</th>
							<td>{{ $product->name }}</td>
							<td>
								<div class="d-flex">
									<a href="/products/{{ $product->id }}/edit"
									   class="btn btn-sm btn-primary">
										<i class="fa fa-edit"></i>
									</a>
									<div class="mx-1">
										{{-- Confirm Delete Modal End --}}
										<div class="modal fade"
											 id="deleteModal{{ $product->id }}"
											 tabIndex="-1"
											 aria-labelledby="deleteModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h1 id="deleteModalLabel"
															class="modal-title fs-5 text-danger">
															Delete Product
														</h1>
														<button type="button"
																class="btn-close"
																data-bs-dismiss="modal"
																aria-label="Close"></button>
													</div>
													<div class="modal-body text-wrap">
														@if ($product->hasOrders)
														Sorry, you cannot delete this product since it has orders associated with it.
														@else
														Are you sure you want to delete {{ $product->name }}.
														This process is irreversible.
														@endif
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
						                                                     document.getElementById('deleteForm{{ $product->id }}').submit();">
														</button>
														<form id="deleteForm{{ $product->id }}"
															  action="/products/{{ $product->id }}"
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
												style="background-color: gray;"
												data-bs-toggle="modal"
												data-bs-target="#deleteModal{{ $product->id }}">
											<i class="fa fa-trash"></i>
											{{-- {{ gettype($product->hasOrders) }} --}}
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
				{{ $products->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection