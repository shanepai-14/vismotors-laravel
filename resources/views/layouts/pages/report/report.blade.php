<x-app-layout>
    @push('styles')
     <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">   
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">   
    @endpush
    <div class="page-content">
    <section class="card  p-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
   
            
        <div style="min-height:500px; width:100%">
          <div class="d-flex justify-content-between">
            <h3>Payment report as of this month</h3>
            <div class="mb-3">
                <label for="month-select" class="form-label">Select Month:</label>
                <select class="form-control" id="month-select" name="month">
                    @php
                        $currentMonth = Carbon\Carbon::now()->format('Y-m');
                    @endphp
                    @foreach (range(1, 12) as $month)
                        @php
                            $monthValue = Carbon\Carbon::now()->startOfYear()->addMonths($month - 1)->format('Y-m');
                            $isSelected = ($monthValue == $currentMonth);
                        @endphp
                        <option value="{{ $monthValue }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ Carbon\Carbon::createFromDate(null, $month, null)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
          </div>
            <table class="table table-striped table-bordered" id="datatable_montly" style="width:100%; ">
                <thead>
                    <tr>
                        <th style="width: 10%">Contract#</th>
                        <th style="width: 10%">OR#</th>
                        <th style="width: 20%">Amount</th>
                        <th style="width: 20%">Payment method</th>
                        <th style="width: 20%">Cashier</th>
                        <th style="width: 10%">Date</th>
                        <th style="width: 10%">Balance</th>
                 
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($payments as $payment)
                        <tr>
                            <td>
                                {{ $payment->ref_no }}
                            </td>
                            <td>
                                {{ $payment->or_number }}
                            </td>
                            </td>
                            <td>
                                ₱{{ number_format($payment->amount,2, '.', ',') }}
                            </td>
                            <td>
          
                                {{ $payment->payment_method }}
                            </td>
                              <td>{{$payment->cashier->first_name ." ". $payment->cashier->last_name}}</td>

                            <td>
                                {{ formatDate($payment->created_at) }} 
                            </td>

                            <td>₱{{ number_format(isset($payment->balance) ? $payment->balance : 0,2, '.', ',')}}</td>
                      
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
       
        
      </section>
    </div>
    @push('scripts')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
     <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script>
             $(function() {
      const table =   $('#datatable_montly').DataTable({
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    },
    processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('monthly_report') }}',
                    data: function(d) {
                        d.month = $('#month-select').val();
                    }
                },
                columns: [
                    { data: 'contract' },
                    { data: 'or_number' },
                    { data: 'amount' },
                    { data: 'payment_method' },
                    { data: 'cashier' },
                    { data: 'date' },
                    { data: 'balance' }
                ]
});
$('#month-select').change(function() {
                table.ajax.reload();
            });
        })
    </script>
    @endpush
	@section('additional_css')
		{{-- <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" /> --}}
	@endsection
	@section('additional_scripts')
		{{-- <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script> --}}
		@include('layouts.shared.table-scripts')
	@endsection
</x-app-layout>
