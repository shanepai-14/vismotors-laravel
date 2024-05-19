<x-app-layout>
	<div class="page-content">
		<div class="row">
			<div class="col">
				<div class="card radius-10 bg-gradient-ibiza">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div class="me-auto">
								<p class="mb-0 text-light">Total Transactions</p>
								<h4 class="my-1 text-light">{{ $total_trans }}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10 bg-gradient-ibiza">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div class="me-auto">
								<p class="mb-0 text-light">Total Revenue</p>
								<h4 class="my-1 text-light">₱84,245</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card radius-10 bg-gradient-ibiza">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div class="me-auto">
								<p class="mb-0 text-light">Total Customers</p>
								<h4 class="my-1 text-light">{{ $total_cust }}</h4>
								{{-- <p class="mb-0 font-13 text-dark">+8.4% from last week</p> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--end row-->

		<div class="card radius-10">
			<div class="card-header">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Recent Transactions</h6>
					</div>
				</div>
			</div>
			<div class="card-body">

				<div class="table-responsive">
					<table class="table align-middle mb-0">
						<thead class="table-light">
							<tr>
								<th>Customer</th>
								<th>Motorcycle</th>
								<th>Status</th>
								<th>Amount</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>

							@foreach ($trans as $transaction)
								<tr>
									<td>{{ $transaction->customers->fullname() }}</td>
									@php
										$motor = App\Models\Motor::find($transaction->motors->motor_id);
									@endphp
									<td>{{ $motor->brand->name }} {{ $motor->modelnameyear() }} - {{ $transaction->motors->color }}</td>
									<td>
										<span class="badge bg-gradient-quepal text-white shadow-sm w-100">
											{{ $transaction->statuses->name }}
										</span>
									</td>
									<td>
										@if ($transaction->trans_type_id == 2)
											<b>Monthly Payment:</b> {{ $transaction->monthly_due }} for {{ $transaction->loan_tenure_months }} months
										@else
                                            <b>Cash Payment: {{ $transaction->motors->price_cash }}</b>
										@endif
									</td>
									<td>{{ Carbon\Carbon::parse($transaction->created_at)->format('M d, Y') }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
