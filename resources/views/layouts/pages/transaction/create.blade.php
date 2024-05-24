<x-app-layout>
	<div class="page-content">
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route('transaction.index') }}">Transactions</a>
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
						<h6 class="card-title">Add New Transaction</h6>
						<hr />
						<div class="form-body mt-4">
							<div class="row">
								<div class="col-12">
									<div class="border border-3 p-4 rounded">
										@if (isset($transaction))
											<form action="{{ route('transaction.update', ['transaction' => $transaction]) }}"
												enctype='multipart/form-data' method="post">
												@method('put')
											@else
												<form action="{{ route('transaction.store') }}" enctype="multipart/form-data" method="post">
										@endif
										@csrf

										@if ($errors->any())
											{{ implode('', $errors->all('<div>:message</div>')) }}
										@endif
										<div class="row g-3 mb-2">
											@if(isset($transaction->ref_no))
											<h3>Contract Number : <i>{{$transaction->ref_no}}</i></h3>
											@endif
											<div class="col-4">
												<label class="form-label" for="customer_id">Customer</label>
												<select class="form-select" id="customer_id" name="customer_id" required>
													<option selected value="">--Select--</option>
													@foreach ($customers as $customer)
														<option
															{{ old('customer_id', isset($transaction) && $transaction->customer_id == $customer->id ? 'selected' : '') }}
															value="{{ $customer->id }}">
															{{ $customer->fullname() }}
														</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<label class="form-label" for="trans_type_id">Transaction Type</label>
												<select class="form-select" id="trans_type_id" name="trans_type_id" required>
													<option selected value="">--Select--</option>
													@foreach ($transaction_types as $transaction_type)
														<option
															{{ old('trans_type_id', isset($transaction) && $transaction->trans_type_id == $transaction_type->id ? 'selected' : '') }}
															value="{{ $transaction_type->id }}">
															{{ $transaction_type->name }}
														</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<label class="form-label" for="motor_id">Motorcycle</label>
												<select class="form-select" id="motor_id" name="motor_id" required>
													<option selected value="">--Select--</option>
													@foreach ($motors as $motor)
														@foreach ($motor->colors as $color)
															@if ($color->quantity != 0)
																<option
																	{{ old('motor_id', isset($transaction) && $transaction->motor_id == $color->motor_id ? 'selected' : '') }}
																	data-cash="{{ $color->price_cash }}" value="{{ $color->id }}">
																	{{ $motor->brand->name }} {{ $motor->modelnameyear() }} - {{ $color->color }} - QTY : {{$color->quantity}}
																</option>
															@endif
														@endforeach
													@endforeach
												</select>
											</div>
											<div class="col-3">
												<label class="form-label" for="downpayment">Downpayment</label>
												<input
													@isset($transaction)
                                                        disabled
                                                    @endisset
													class="form-control" id="downpayment" name="downpayment" type="text"
													value="{{ old('downpayment', isset($transaction->downpayment) ? $transaction->downpayment : '') }}" required>
											</div>
											<div class="col-3" id="loan" style="display : {{ isset($transaction->loan_tenure_months) && $transaction->loan_tenure_months == '0'  ?  'none' : 'block' }}">
												<label class="form-label" for="loan_tenure_months">Loan Tenure (Months)</label>
												<input class="form-control" id="loan_tenure_months" name="loan_tenure_months" type="number"
													value="{{ old('loan_tenure_months', isset($transaction->loan_tenure_months) ? $transaction->loan_tenure_months : '') }}">
											</div>
											<div class="col-3">
												<label class="form-label" for="chassis">Chassis</label>
												<input
												
													class="form-control" id="chassis" name="chassis" type="text"
													value="{{ old('chassis', isset($transaction->chassis) ? $transaction->chassis : '') }}" required>
											</div>
											<div class="col-3" id="due_date" style="display : {{ isset($transaction->due_date) && $transaction->due_date == '0'  ?  'none' : 'block' }}">
												<label class="form-label" for="loan_tenure_months">Due Date</label>
												<div class="d-flex gap-2  align-items-center">
													<p class="m-0">Every </p> 
													
													<select class="form-select" style="width:90px" name="due_date">
														<option value="1" {{ isset($transaction->due_date) && $transaction->due_date == '1' ? 'selected' : '' }}>1st</option>
														<option value="2" {{ isset($transaction->due_date) && $transaction->due_date == '2' ? 'selected' : '' }}>2nd</option>
														<option value="3" {{ isset($transaction->due_date) && $transaction->due_date == '3' ? 'selected' : '' }}>3rd</option>
														<option value="4" {{ isset($transaction->due_date) && $transaction->due_date == '4' ? 'selected' : '' }}>4th</option>
														<option value="5" {{ isset($transaction->due_date) && $transaction->due_date == '5' ? 'selected' : '' }}>5th</option>
														<option value="6" {{ isset($transaction->due_date) && $transaction->due_date == '6' ? 'selected' : '' }}>6th</option>
														<option value="7" {{ isset($transaction->due_date) && $transaction->due_date == '7' ? 'selected' : '' }}>7th</option>
														<option value="8" {{ isset($transaction->due_date) && $transaction->due_date == '8' ? 'selected' : '' }}>8th</option>
														<option value="9" {{ isset($transaction->due_date) && $transaction->due_date == '9' ? 'selected' : '' }}>9th</option>
														<option value="10" {{ isset($transaction->due_date) && $transaction->due_date == '10' ? 'selected' : '' }}>10th</option>
														<option value="11" {{ isset($transaction->due_date) && $transaction->due_date == '11' ? 'selected' : '' }}>11th</option>
														<option value="12" {{ isset($transaction->due_date) && $transaction->due_date == '12' ? 'selected' : '' }}>12th</option>
														<option value="13" {{ isset($transaction->due_date) && $transaction->due_date == '13' ? 'selected' : '' }}>13th</option>
														<option value="14" {{ isset($transaction->due_date) && $transaction->due_date == '14' ? 'selected' : '' }}>14th</option>
														<option value="15" {{ isset($transaction->due_date) && $transaction->due_date == '15' ? 'selected' : '' }}>15th</option>
														<option value="16" {{ isset($transaction->due_date) && $transaction->due_date == '16' ? 'selected' : '' }}>16th</option>
														<option value="17" {{ isset($transaction->due_date) && $transaction->due_date == '17' ? 'selected' : '' }}>17th</option>
														<option value="18" {{ isset($transaction->due_date) && $transaction->due_date == '18' ? 'selected' : '' }}>18th</option>
														<option value="19" {{ isset($transaction->due_date) && $transaction->due_date == '19' ? 'selected' : '' }}>19th</option>
														<option value="20" {{ isset($transaction->due_date) && $transaction->due_date == '20' ? 'selected' : '' }}>20th</option>
														<option value="21" {{ isset($transaction->due_date) && $transaction->due_date == '21' ? 'selected' : '' }}>21st</option>
														<option value="22" {{ isset($transaction->due_date) && $transaction->due_date == '22' ? 'selected' : '' }}>22nd</option>
														<option value="23" {{ isset($transaction->due_date) && $transaction->due_date == '23' ? 'selected' : '' }}>23rd</option>
														<option value="24" {{ isset($transaction->due_date) && $transaction->due_date == '24' ? 'selected' : '' }}>24th</option>
														<option value="25" {{ isset($transaction->due_date) && $transaction->due_date == '25' ? 'selected' : '' }}>25th</option>
														<option value="26" {{ isset($transaction->due_date) && $transaction->due_date == '26' ? 'selected' : '' }}>26th</option>
														<option value="27" {{ isset($transaction->due_date) && $transaction->due_date == '27' ? 'selected' : '' }}>27th</option>
														<option value="28" {{ isset($transaction->due_date) && $transaction->due_date == '28' ? 'selected' : '' }}>28th</option>
														<option value="29" {{ isset($transaction->due_date) && $transaction->due_date == '29' ? 'selected' : '' }}>29th</option>
														<option value="30" {{ isset($transaction->due_date) && $transaction->due_date == '30' ? 'selected' : '' }}>30th</option>
														<option value="31" {{ isset($transaction->due_date) && $transaction->due_date == '31' ? 'selected' : '' }}>31st</option>
													</select>
													
													<p class="m-0"> of the month</p>
												</div>
											</div>
											
											<div class="col-12 d-flex justify-content-end">
												<a class="btn btn-danger btn-sm mx-2" href="{{ route('transaction.index') }}">Cancel</a>
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
	@push('scripts')
	<script>
		$(document).ready(function() {

$('.form-select').select2();

});
		var value;
		let motor = document.getElementById('motor_id');
		let due_date = document.getElementById('due_date');
		var cash;
		var downpayment = document.getElementById('downpayment');
        document.getElementById('trans_type_id').addEventListener('change', function() {
			var inputField = document.getElementById('loan');
			value = this.value;
            if (value  === '1') {
                inputField.style.display = 'none';
				due_date.style.display = 'none';
			  if(cash != undefined) {
				downpayment.value = cash;
				downpayment.setAttribute('readonly', true);
				
			  }
            } 
			else  {
				inputField.style.display = 'block';
				downpayment.value ='';
				downpayment.removeAttribute('readonly');
				due_date.style.display = 'block';
            }
        });

		document.getElementById('motor_id').addEventListener('change', function() {
			cash = motor.options[motor.selectedIndex].getAttribute('data-cash');
        console.log(cash);
		console.log(value);
            if(value === '1'){
				downpayment.value = cash;
				downpayment.setAttribute('readonly', true);
				due_date.style.display = 'none';
			}
			 else{
                downpayment.value ='';
                downpayment.removeAttribute('readonly');
            }
    


		});
    </script>
	@endpush
</x-app-layout>
