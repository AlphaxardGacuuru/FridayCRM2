@extends('layouts.app')

@section('content')
<div class="row">
	{{-- basic table --}}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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