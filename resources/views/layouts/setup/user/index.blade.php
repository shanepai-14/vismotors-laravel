<x-app-layout>
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li aria-current="page" class="breadcrumb-item active">{{ $type === 'customer' ? 'Customer' : 'Employee' }}</li>
					</ol>
				</nav>
			</div>
		</div>
		@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
		<div class="row d-flex justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-9">
								<h5 class="mb-0 text-uppercase">{{ $type === 'customer' ? 'Customer' : 'Employee' }}</h5>
							</div>
							<div class="col-3 d-flex justify-content-end">
							@if($type === 'customer')
							<a class="btn btn-primary" href="{{ route('user.create') }}" onclick="handleEditButtonClick()">Add Customer</a>
							@else
							<a class="btn btn-primary" href="{{ route('user.employee.create') }}" onclick="handleEditButtonClick()">Add Employee</a>
							@endif
							</div>
						</div>
						<table class="table table-striped table-bordered" id="datatable" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Username & Email</th>
									<th>Role</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
									<tr>
										<td>{{ $user->fullname() }}</td>
										<td>
											<div class="row">
												<div class="col-12">
													<b>{{ $user->username }}</b>
												</div>
												<div class="col-12">
                                                    <i>{{ $user->email }}</i>
												</div>
											</div>
										</td>
										<td>
											<div class="row">
												@foreach ($user->roles as $role)
													<div class="col-6">
														<span class="badge bg-success">{{ $role->name }}</span>
													</div>
												@endforeach
											</div>
										</td>
										<td>
											<div class="ms-auto">
												<div class="btn-group">
													@if($type === 'customer')
													<a class="btn btn-primary btn-sm" href="{{ route('user.edit', ['user' => $user]) }}" onclick="handleEditButtonClick()">Edit</a>

													@else
													<a class="btn btn-primary btn-sm" href="{{ route('user.employee.edit', ['user' => $user]) }}" onclick="handleEditButtonClick()">Edit</a>
													@endif
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@push('scripts')
	<script>
	   

		 function handleEditButtonClick() {
	// Get the role value from the PHP variable
	const role = @json(auth()->user()->roles[0]->name);
	
	// Check if the role is 'cashier'
	if (role === 'cashier' || role === 'member') {
			event.preventDefault();
			return Notiflix.Notify.failure("You dont have enough permissions");
	} 
}
	</script>
@endpush
	@section('additional_css')
		<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	@endsection
	@section('additional_scripts')
		<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
		@include('layouts.shared.table-scripts')
	@endsection
</x-app-layout>
