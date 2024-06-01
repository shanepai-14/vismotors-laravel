<x-app-layout>
	<div class="page-content">
		<!--breadcrumb-->
		<style>

			.btn-secondary-emphasis{
				background-color: #a7acb1;
			}
			.btn-success-emphasis{
				background-color: #75b798;
			}
		</style>
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
			<x-modals id="myModal" title="Status">
				<form action="{{ route('status.update') }}" method="POST" >
					@csrf
					@method('PUT')
					<input type="hidden" name="transaction_id" id="transaction_id" value="">
					<input type="hidden" name="status_id" id="status_id" value="">
					<h3 id="desc">Are you sure you want to approve this transaction?</h3>
					<div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
						<button type="submit" class="btn btn-lg btn-success" id="approve"  onclick="submitForm(2)">Approve</button>
						<button type="submit" class="btn btn-lg btn-secondary-emphasis" id="inactive"  onclick="submitForm(4)">Inactive</button>
					<span id="approve_btn" class="gap-3 flex-column">
						<button type="submit" class="btn btn-lg btn-primary w-100"  onclick="submitForm(3)">Active</button>
						<button type="submit" class="btn btn-lg btn-success w-100"  onclick="submitForm(5)">Paid</button>
						<button type="submit" class="btn btn-lg btn-danger w-100"  onclick="submitForm(6)">Unpaid</button>
					</span>
						<button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Close</button>
					  </div>
				</form>
			  </x-modals>
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
														<b>Monthly Payment:</b> {{ number_format($transaction->monthly_due,2,'.',',') }} for {{ $transaction->loan_tenure_months }} months
													</div>
												@endif
												@if(isset($transaction->due_date) && $transaction->due_date !== '0')
												<div class="col-12">
													<b>Due Date : </b> every <i class="text-danger">{{ $transaction->due_date.getDaySuffix($transaction->due_date) }}</i> of the month
												</div>
												@endif
												<div class="col-12">
                                                         @php
														   $bg_colors = ["bg-success", "bg-warning", "bg-info", "bg-primary", "btn-secondary-emphasis", "bg-success","bg-danger"];

														 @endphp

													<span class="badge {{ $bg_colors[$transaction->statuses->id] }}">{{ $transaction->statuses->name }}</span>
												</div>
											</div>
										</td>
										<td>
											{{formatDate($transaction->created_at) }}
										</td>
										<td>
											<div class="ms-auto">
												<div class="btn-group">
													<a class="btn btn-primary btn-sm {{ $transaction->statuses->name == 'Pending' ? 'd-none' : '' }}" 
														href="{{ route('transaction.edit', ['transaction' => $transaction]) }}" onclick="handleEditButtonClick('{{$transaction->statuses->name}}')"  id="edit_btn">Edit</a>
													<a class="btn btn-warning btn-sm"
														href="{{ route('payment.transaction', ['transaction' => $transaction]) }}"  onclick="handleEditButtonClick('{{$transaction->statuses->name}}')" id="pay_btn">Pay</a>
														<button type="button" class="btn btn-info btn-sm" id="status_btn"  onclick="approval({{$transaction->id}},{{$transaction->statuses->id}}); handleEditButtonClick('{{$transaction->statuses->name}}');" {{ $transaction->statuses->name == 'Pending' && auth()->user()->roles[0]->name == 'cashier' ? '' : 'data-bs-target=#myModal  data-bs-toggle=modal' }}>
															Status
															</button>
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
	@push('scripts')
		<script>
           
	
			 function handleEditButtonClick(status) {
        // Get the role value from the PHP variable
        const role = @json(auth()->user()->roles[0]->name);
        
        // Check if the role is 'cashier'
        if (role === 'cashier' || role === 'member') {
			
            if(status === 'Pending'){
				event.preventDefault();
				return Notiflix.Notify.info("Waiting for admin aprroval.");
			}

        } 
    }
		</script>
	@endpush
	@section('additional_scripts')
	
	<script>
		     
       function approval(id,status_id){
         $('#transaction_id').val(id);
		 $('#status_id').val(status_id);
		 if(status_id == 2){
			console.log(status_id);
			$('#approve').hide();
			$('#desc').text('Are you sure you want to update this transaction?');
			$('#approve_btn').css('display', 'flex');
		
		 }else{
			console.log(status_id);
			$('#approve_btn').css('display', 'none');
			$('#approve').show();
			$('#desc').text('Are you sure you want to approve this transaction?');
		 }
       }
	   function submitForm(statusId) {
        document.getElementById('status_id').value = statusId;
        document.getElementById('status-form').submit();
    }
	   

	</script>
		<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
		@include('layouts.shared.table-scripts')
	@endsection
</x-app-layout>
