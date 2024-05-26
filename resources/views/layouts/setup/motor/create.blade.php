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
						<li aria-current="page" class="breadcrumb-item active">Create</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-body p-4">
						<h6 class="card-title">Add New Motorcycle</h6>
						<hr />
						<div class="form-body mt-4">
							<div class="row">
								<div class="col-12">
									<div class="border border-3 p-4 rounded">
										@if (isset($motor))
											<form action="{{ route('motor.update', ['motor' => $motor]) }}"
												enctype='multipart/form-data' method="post">
												@method('put')
											@else
												<form action="{{ route('motor.store') }}" enctype="multipart/form-data" method="post">
										@endif
										@csrf

										@if ($errors->any())
											{{ implode('', $errors->all('<div>:message</div>')) }}
										@endif
										<div class="row g-3 mb-2">
											<div class="col-4">
												<label class="form-label" for="brand_id">Brand</label>
												<select class="form-select" id="brand_id" name="brand_id">
													<option selected value="">--Select--</option>
													@foreach ($brands as $brand)
														<option {{ old('brand_id', isset($motor) && $motor->brand_id == $brand->id ? 'selected' : '') }}
															value="{{ $brand->id }}">
															{{ $brand->name }}
														</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<label class="form-label" for="model_name">Model Name</label>
												<input class="form-control" id="model_name" name="model_name" type="text"
													value="{{ old('model_name', isset($motor->model_name) ? $motor->model_name : '') }}">
											</div>
											<div class="col-4">
												<label class="form-label" for="model_year">Model Year</label>
												<input class="form-control" id="model_year" name="model_year" type="text"
													value="{{ old('model_year', isset($motor->model_year) ? $motor->model_year : '') }}">
											</div>
											<div class="col-12">
												<label class="form-label" for="specifications">Specifications</label>
												<textarea class="form-control" id="specifications" name="specifications" rows="4"
													>{{ old('specifications', isset($motor->specifications) ? $motor->specifications : '') }}</textarea>
											</div>
											<div class="col-12 d-flex justify-content-end">
												<a class="btn btn-danger btn-sm mx-2" href="{{ route('motor.index') }}">Cancel</a>
												<button class="btn btn-primary btn-sm" type="submit">Save</button>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div><!--end row-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
