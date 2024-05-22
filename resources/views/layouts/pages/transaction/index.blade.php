<x-app-layout>
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li aria-current="page" class="breadcrumb-item active">Transactions</li>
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
								<h5 class="mb-0 text-uppercase">Transactions</h5>
							</div>
							<div class="col-3 d-flex justify-content-end">
								<a class="btn btn-primary" href="{{ route('transaction.create') }}">Add</a>
							</div>
						</div>
						<table class="table table-striped table-bordered" id="datatable" style="width:100%">
							<thead>
								<tr>
									<th style="width: 13%">Contract No.</th>
									<th style="width: 30%">Customer</th>
									<th style="width: 40%">Details</th>
									<th style="width: 10%">Date</th>
									<th style="width: 7%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($transactions as $transaction)
									<tr>
										<td>
											{{ $transaction->ref_no }}
                                        </td>
										</td>
										<td>
											{{ $transaction->customers->fullname() }}
										</td>
										<td>
											@php
												$motor = App\Models\Motor::find($transaction->motors->motor_id);
											@endphp
											<div class="row">
												<div class="col-12">
													<b>{{ $motor->brand->name }} {{ $motor->modelnameyear() }} - {{ $transaction->motors->color }}</b>
												</div>
												<div class="col-12">
													<b>Payment Type:</b> <i>{{ $transaction->transaction_types->name }}</i>
												</div>
												@if ($transaction->trans_type_id == 2)
													<div class="col-12">
														<b>Monthly Payment:</b> {{ $transaction->monthly_due }} for {{ $transaction->loan_tenure_months }} months
													</div>
												@endif
												@if(isset($transaction->due_date) && $transaction->due_date !== '0')
												<div class="col-12">
													<b>Due Date : </b> every <i class="text-danger">{{ $transaction->due_date.getDaySuffix($transaction->due_date) }}</i> of the month
												</div>
												@endif
												<div class="col-12">
													<span class="badge bg-success">{{ $transaction->statuses->name }}</span>
												</div>
											</div>
										</td>
										<td>
											{{formatDate($transaction->created_at) }}
										</td>
										<td>
											<div class="ms-auto">
												<div class="btn-group">
													<a class="btn btn-primary btn-sm"
														href="{{ route('transaction.edit', ['transaction' => $transaction]) }}">Edit</a>
													<a class="btn btn-warning btn-sm"
														href="{{ route('payment.transaction', ['transaction' => $transaction]) }}">Pay</a>
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
