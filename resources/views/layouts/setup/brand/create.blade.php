<x-app-layout>
	<div class="page-content">
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Brands</a>
						</li>
						<li aria-current="page" class="breadcrumb-item active">Create</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<div class="col-8">
				<div class="card">
					<div class="card-body p-4">
						<h6 class="card-title">Add New Brand</h6>
						<hr />
						<div class="form-body mt-4">
							<div class="row">
								<div class="col-12">
									<div class="border border-3 p-4 rounded">
										@if (isset($brand))
											<form action="{{ route('brand.update', ['brand' => $brand->id]) }}" enctype='multipart/form-data'
												method="post">
												@method('put')
											@else
												<form action="{{ route('brand.store') }}" enctype="multipart/form-data" method="post">
										@endif
										@csrf
										<div class="row g-3 mb-2">
											<div class="col-12">
												<label class="form-label" for="name">Name</label>
												<input class="form-control" id="name" name="name" type="text" value="{{ old('name', isset($brand->name) ? $brand->name : '') }}">
											</div>
											{{-- <div class="col-12">
                                                <label class="form-label" for="inputCollection">Collection</label>
                                                <select class="form-select" id="inputCollection">
                                                    <option></option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div> --}}
											<div class="col-12 d-flex justify-content-end">
												<a class="btn btn-danger btn-sm mx-2" href="{{ route('brand.index') }}">Cancel</a>
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
