<x-app-layout>
	<div class="page-content">
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route('motor.index') }}">Motorcycles</a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route('color.index', ['motor' => $motor->id]) }}">Colors for
								{{ $motor->brand->name }} {{ $motor->modelnameyear() }}</a>
						</li>
						<li aria-current="page" class="breadcrumb-item active">Create</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-body p-4">
						<h6 class="card-title">Add New color for {{ $motor->brand->name }} {{ $motor->modelnameyear() }}</h6>
						<hr />
						<div class="form-body mt-4">
							<div class="row">
								<div class="col-12">
									<div class="border border-3 p-4 rounded">
										@if (isset($color))
											<form action="{{ route('color.update', ['motor' => $motor, 'color' => $color]) }}"
												enctype='multipart/form-data' method="post">
												@method('put')
											@else
												<form action="{{ route('color.store', ['motor' => $motor]) }}" enctype="multipart/form-data" method="post">
										@endif
										@csrf

										@if ($errors->any())
											{{ implode('', $errors->all('<div>:message</div>')) }}
										@endif
										<div class="row g-3 mb-2">
											<div class="col-4">
												<label class="form-label" for="color">Color</label>
												<input class="form-control" id="color" name="color" type="text"
													value="{{ old('color', isset($color->color) ? $color->color : '') }}">
											</div>
											<div class="col-4">
												<label class="form-label" for="quantity">Quantity</label>
												<input class="form-control" id="quantity" name="quantity" type="number"
													value="{{ old('quantity', isset($color->quantity) ? $color->quantity : '') }}">
											</div>
											<div class="col-4">
												<label class="form-label" for="interest_rate">Interest Rate</label>
												<input class="form-control" id="interest_rate" name="interest_rate" type="number"
													value="{{ old('interest_rate', isset($color->interest_rate) ? $color->interest_rate : '') }}">
											</div>
											<div class="col-4">
												<label class="form-label" for="price_cash">Cash Price</label>
												<input class="form-control" id="price_cash" name="price_cash" type="number"
													value="{{ old('price_cash', isset($color->price_cash) ? $color->price_cash : '') }}">
											</div>
											<div class="col-4">
												<label class="form-label" for="price_installment">Installment Price</label>
												<input class="form-control" id="price_installment" name="price_installment" type="number"
													value="{{ old('price_installment', isset($color->price_installment) ? $color->price_installment : '') }}">
											</div>
											<div class="col-4">
												<label class="form-label" for="motor_type_id">Motor Type</label>
												<select class="form-select" id="motor_type_id" name="motor_type_id">
													<option selected value="">--Select--</option>
													@foreach ($types as $motor_type)
														<option
															{{ old('motor_type_id', isset($color) && $color->motor_type_id == $motor_type->id ? 'selected' : '') }}
															value="{{ $motor_type->id }}">
															{{ $motor_type->name }}
														</option>
													@endforeach
												</select>
											</div>
											<div class="col-12 d-flex justify-content-end">
												<a class="btn btn-danger btn-sm mx-2" href="{{ route('color.index', ['motor' => $motor]) }}">Cancel</a>
												<button class="btn btn-primary btn-sm" type="submit">Save</button>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
