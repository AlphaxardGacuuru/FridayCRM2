@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		{{-- Filters --}}
		<div class="card p-4 ms-auto"
			 style="color: gray;">
			<form action="/users">
				<div class="d-flex">
					{{-- Name --}}
					<div class="flex-grow-1 mb-2">
						<input id=""
							   name="name"
							   placeholder="Search by name"
							   type="text"
							   value="{{ $request->input('name') }}"
							   class="form-control w-100" />
					</div>
					{{-- Name End --}}
					{{-- Search --}}
					<div class="mx-2">
						<button type="submit"
								class="btn btn-sm btn-primary ms-auto">
							<i class="fa fa-search"></i> Search
						</button>
					</div>
					{{-- Search End --}}
				</div>
			</form>
		</div>
		{{-- Filters End --}}

		<div class="card">
			<div class="d-flex justify-content-between card-header">
				<h3 class="">Customers</h3>
				<a href="/users/create"
				   class="btn btn-primary">
					<i class="fa fa-pen-square"></i> Create</a>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">SN</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Phone</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						<tr>
							<th scope="row">{{ $loop->iteration + ($users->perPage() * ($users->currentPage() - 1)) }}
							</th>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->phone }}</td>
							<td>
								<div class="d-flex">
									<a href="/users/{{ $user->id }}"
									   class="btn btn-sm btn-primary me-1">
										<i class="fa fa-eye"></i>
									</a>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				{{ $users->links() }}
			</div>
		</div>
	</div>
	{{-- end basic table --}}
</div>
@endsection