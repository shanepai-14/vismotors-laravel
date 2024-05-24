<x-app-layout>
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li aria-current="page" class="breadcrumb-item active">Motorcycles</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-9">
								<h5 class="mb-0 text-uppercase">Motorcycles</h5>
							</div>
							<div class="col-3 d-flex justify-content-end">
								<a class="btn btn-primary" href="{{ route('motor.create') }}">Add</a>
							</div>
						</div>
						<table class="table table-striped table-bordered" id="datatable" style="width:100%">
							<thead>
								<tr>
									<th style="width: 30%">Name</th>
									<th style="width: 40%">Specifications</th>
									<th style="width: 10%">Quantity</th>
									<th style="width: 20%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($motors as $motor)
									<tr>
										<td>
											<div class="row">
												<div class="col-12">
													<b>{{ $motor->brand->name }}</b> {{ $motor->model_name }}
												</div>
												<div class="col-12">
													<i>{{ $motor->model_year }}</i>
												</div>
											</div>
										</td>
										<td>
											<span>{{ $motor->specifications }}</span>
										</td>
										<td>
											@if(count($motor->colors) > 0)
											@php
												$total = 0;
											@endphp
											@foreach($motor->colors as $color)
												@php
													$total += $color->quantity
												@endphp
											@endforeach
											{{ $total }}
										@else
											<span>0</span>
										@endif

										 
										</td>
										<td>
											<div class="ms-auto">
												<div class="btn-group">
													<a class="btn btn-primary btn-sm" href="{{ route('motor.edit', ['motor' => $motor]) }}">Edit</a>
													<a class="btn btn-success btn-sm" href="{{ route('color.index', ['motor' => $motor]) }}">Color</a>
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
	@section('additional_css')
		<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	@endsection
	@section('additional_scripts')
		<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
		@include('layouts.shared.table-scripts')
	@endsection
</x-app-layout>
