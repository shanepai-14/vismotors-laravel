<x-app-layout>
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route('motor.index') }}">Motorcycles</a>
						</li>
						<li aria-current="page" class="breadcrumb-item active">Colors for {{ $motor->brand->name }} {{ $motor->modelnameyear() }}</li>
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
								<h5 class="mb-0 text-uppercase">Colors for {{ $motor->brand->name }} {{ $motor->modelnameyear() }}</h5>
							</div>
							<div class="col-3 d-flex justify-content-end">
								<a class="btn btn-primary" href="{{ route('color.create', ['motor' => $motor->id]) }}">Add</a>
							</div>
						</div>
						<table class="table table-striped table-bordered" id="datatable" style="width:100%">
							<thead>
								<tr>
									<th style="width: 20%">Color</th>
									<th style="width: 40%">Price</th>
									<th style="width: 25%">Quantity</th>
									<th style="width: 20%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($color_keys as $color)
									<tr>
										<td><b>{{ $color->color }}</b></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <b>Cash: </b> {{ number_format($color->price_cash, 2) }}
                                                </div>
                                                <div class="col-12">
                                                    <b>Installment: </b> {{ number_format($color->price_installment, 2) }}
                                                </div>
                                                <div class="col-12">
                                                    <b>Interest Rate: </b> {{ number_format($color->interest_rate, 2) }}%
                                                </div>
                                            </div>
                                        </td>
										<td>
											{{ $color->quantity}}
										</td>
										<td>
											<div class="ms-auto">
												<div class="btn-group">
													{{-- <a class="btn btn-primary btn-sm"
														href="{{ route('color.edit', ['motor' => $motor,'color' => $color]) }}">Edit</a> --}}
														<a class="btn btn-warning btn-sm" onclick="addStock({{$color->id}},'{{$color->quantity}}')"
														href="#" data-bs-target='#myModal'   data-bs-toggle="modal">Add Stock</a>
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
	<x-modals id="myModal" title="Add stock">
		<form action="{{route('quantity.update') }}" method="POST" >
			@csrf
			@method('PUT')
			<div class="d-flex flex-column gap-4">
				<input type="hidden" name="color_id" id="color_id" value="">
				<input type="hidden" name="motor_id" id="motor_id" value="{{$motor->id}}">
			<h3 id="desc">{{ $motor->brand->name }} {{ $motor->modelnameyear() }} - <span>Matte Black</span></h3>
			<h5>Current Quantity &nbsp;:&nbsp;&nbsp;&nbsp; <b id="current_quantity"></b> </h5>
			<div class="d-flex gap-2 justify-content-center align-items-center">
				<h5 class="text-nowrap mb-0">Quantities to Add : </h5>
				<input class="form-control" id="quantity" name="quantity" type="number" value="">
			</div>
			<button type="submit" class="btn btn-lg btn-success w-100" >Add Quantity</button>
			</div>
		</form>
	  </x-modals>
	@section('additional_css')
		<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	@endsection
	@section('additional_scripts')
	<script>
		 function addStock(color_id,current_quantity,) {
        document.getElementById('color_id').value = color_id;
        document.getElementById('current_quantity').innerHTML = current_quantity;
    }
	</script>
		<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
		@include('layouts.shared.table-scripts')
	@endsection
</x-app-layout>
