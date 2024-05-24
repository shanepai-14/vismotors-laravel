<x-app-layout>
    <div class="page-content">
        <section class="card  p-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="d-flex flex-row align-items-center">
                    <h4 class="text-uppercase mt-1">Payment</h4>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Open Payment Gateway
                </button>
                @php
                    $motor = App\Models\Motor::find($transactions->motors->motor_id);
                @endphp
                <!-- Modal -->
                <x-modals id="myModal">
                    <form action="{{ route('payment.paid') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transactions->id }}">
                        <input type="hidden" name="cashier_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="ref_no" value="{{ $transactions->ref_no }}">
                        <input type="hidden" name="payment_plan" value="{{ $transactions->transaction_types->name }}">
                        <input type="hidden" name="balance" value="{{ $transactions->latest_balance }}">


                        <div class="col-12" id="printJS-form">
                            <h1 class="text-center mb-0">Vismotors Corp.</h1>
                            <p class="text-center mb-4"> <i>{{ date('F j, Y') }}</i></p>

                            <div class="d-flex justify-content-between">
                                <h5 class="mb-3">{{ $motor->brand->name }} {{ $motor->modelnameyear() }} -
                                    {{ $transactions->motors->color }}</h5>

                                @if ($transactions->transaction_types->name == 'Cash')
                                    <h5 class="mb-0 text-success">
                                        ₱{{ number_format($transactions->motors->price_cash, 2, '.', ',') }}</h5>
                                @else
                                    <h5 class="mb-0 text-success">
                                        ₱{{ number_format($transactions->motors->price_installment, 2, '.', ',') }}</h5>
                                @endif
                            </div>

                            <div>
                                <div class="d-flex justify-content-between">

                                    <h6>Contract no :</h6>
                                    <span class="fw-bold text-success ms-1"> {{ $transactions->ref_no }}</span>

                                </div>
                                <div class="d-flex justify-content-between">

                                    <h6>Chassis :</h6>
                                    <span class="fw-bold text-success ms-1"> {{ $transactions->chassis }}</span>

                                </div>
                                <div class="d-flex justify-content-between">

                                    <h6>Account Name</h6>
                                    <span class="fw-bold text-success ms-1"> {{ $transactions->customers->fullname() }}
                                    </span>

                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row mt-1">
                                        <h6>Payment plan</h6>

                                    </div>
                                    <div class="d-flex flex-row align-items-center text-primary">
                                        <span
                                            class="fw-bold text-success ms-1">{{ $transactions->transaction_types->name }}</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                    <h6>Downpayment</h6>
                                    <span
                                        class="fw-bold text-success ms-1">₱{{ number_format($transactions->downpayment, 2, '.', ',') }}</span>
                                </div>
                                @if (isset($transactions->due_date) && $transactions->monthly_due !== '0' && isset($transactions->monthly_due))
                                    <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                        <h6>Interest</h6>
                                        <span
                                            class="fw-bold text-success ms-1">{{ $transactions->motors->interest_rate }}%</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                        <h6>Loan Term</h6>
                                        <span class="fw-bold text-success ms-1">{{ $transactions->loan_tenure_months }}
                                            months</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                        <h6>Due date</h6>
                                        <span class="fw-bold text-success ms-1">Every <i
                                                class="text-danger">{{ $transactions->due_date . '' . getDaySuffix($transactions->due_date) }}</i>
                                            of the month</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                        <h6>Monthy Due</h6>
                                        <span
                                            class="fw-bold text-success ms-1">₱{{ number_format($transactions->monthly_due, 2, '.', ',') }}</span>
                                    </div>
                                @endif

                                <hr />
                                <div class="d-flex mt-1 justify-content-between align-items-center">
                                    <h6>Account Balance</h6>
                                    @if ($transactions->transaction_types->name == 'Cash')
                                        <h6 class="fw-bold text-success ms-1">
                                            ₱{{ number_format($transactions->downpayment - $transactions->getTotalAmountAttribute(), 2, '.', ',') }}
                                        </h6>
                                    @else
                                        <h6 class="fw-bold text-success ms-1">
                                            ₱{{ number_format($transactions->motors->price_installment - $transactions->getTotalAmountAttribute(), 2, '.', ',') }}
                                        </h6>
                                    @endif
                                </div>
                                @if ($transactions->transaction_types->name !== 'Cash')
                                    <div class="d-flex mt-1  justify-content-between align-items-center">
                                        <h6>Total amount dues</h6>
                                        <div class="d-flex align-items-center ">
                                            <h6 class="fw-bold text-success ms-1 m-0">₱</h6><input
                                                class="form-control form-control-sm" name="amount"
                                                style="width: 105px;" type="number"
                                                value="{{ $transactions->monthly_due }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
                                    <h6 class="mb-0">
                                        {{ $transactions->transaction_types->name !== 'Cash' ? 'Payment Method' : 'Total amount paid' }}
                                    </h6>
                                    @if ($transactions->transaction_types->name !== 'Cash')
                                        <div class=" d-flex  align-items-center gap-2" data-gtm-form-interact-id="0">
                                            <div class="d-flex flex-row ">
                                                <div class="d-flex align-items-center pe-2">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="payment_method1" value="Cash" aria-label="..."
                                                        checked="" autocompleted=""
                                                        data-gtm-form-interact-field-id="1">
                                                </div>
                                                <div class="d-flex w-100  align-items-center">
                                                    <p class="mb-0">
                                                        <i class="fab fa-cc-visa fa-lg text-primary pe-2"></i>Cash
                                                    </p>

                                                </div>
                                            </div>

                                        </div>
                                    @else
                                        <span
                                            class="fw-bold text-success ms-1">₱{{ number_format($transactions->downpayment, 2, '.', ',') }}</span>
                                    @endif
                                </div>
                                <hr />

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            @if (isset($transactions->due_date) && $transactions->monthly_due !== '0' && isset($transactions->monthly_due))
                                <button type="submit" class="btn btn-success btn-block">Proceed to payment</button>
                            @else
                                <button type="button" class="btn btn-info btn-block"
                                    onclick="printDiv('printJS-form')">Print</button>
                            @endif

                        </div>
                    </form>
                </x-modals>



            </div>

            <div class="row">
                <div class="col-md-7 col-lg-7 col-xl-6 mb-4 mb-md-0">
                    <h1 class="text-center mb-4">Transaction Details</h1>


                    <div class="d-flex justify-content-between">
                        <h5 class="mb-3">{{ $motor->brand->name }} {{ $motor->modelnameyear() }} -
                            {{ $transactions->motors->color }}</h5>
                        @if ($transactions->transaction_types->name == 'Cash')
                            <h5 class="mb-0 text-success">
                                ₱{{ number_format($transactions->motors->price_cash, 2, '.', ',') }}</h5>
                        @else
                            <h5 class="mb-0 text-success">
                                ₱{{ number_format($transactions->motors->price_installment, 2, '.', ',') }}</h5>
                        @endif
                    </div>

                    <div>

                        <div class="d-flex justify-content-between">

                            <h6>Contract no </h6>
                            <span class="fw-bold text-success ms-1"> {{ $transactions->ref_no }}</span>

                        </div>
                        <div class="d-flex justify-content-between">

                            <h6>Chassis </h6>
                            <span class="fw-bold text-success ms-1"> {{ $transactions->chassis }}</span>

                        </div>
                        <div class="d-flex justify-content-between">

                            <h6>Account Name</h6>
                            <span class="fw-bold text-success ms-1"> {{ $transactions->customers->fullname() }}
                            </span>

                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row mt-1">
                                <h6>Payment plan</h6>

                            </div>
                            <div class="d-flex flex-row align-items-center text-primary">
                                <span
                                    class="fw-bold text-success ms-1">{{ $transactions->transaction_types->name }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                            <h6>Downpayment</h6>
                            <span
                                class="fw-bold text-success ms-1">₱{{ number_format($transactions->downpayment, 2, '.', ',') }}</span>
                        </div>
                        @if ($transactions->transaction_types->name !== 'Cash')
                            <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                <h6>Interest</h6>
                                <span
                                    class="fw-bold text-success ms-1">{{ $transactions->motors->interest_rate }}%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                <h6>Loan Term</h6>
                                <span class="fw-bold text-success ms-1">{{ $transactions->loan_tenure_months }}
                                    months</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                <h6>Due date</h6>
                                <span class="fw-bold text-success ms-1">Every <i
                                        class="text-danger">{{ $transactions->due_date . '' . getDaySuffix($transactions->due_date) }}</i>
                                    of the month</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center bg-body-tertiary">
                                <h6>Monthy Due</h6>
                                <span
                                    class="fw-bold text-success ms-1">₱{{ number_format($transactions->monthly_due, 2, '.', ',') }}</span>
                            </div>
                        @endif
                        <hr />
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <h6>Account Balance</h6>
                            @if ($transactions->transaction_types->name == 'Cash')
                                <h6 class="fw-bold text-success ms-1">
                                    ₱{{ number_format($transactions->downpayment - $transactions->getTotalAmountAttribute(), 2, '.', ',') }}
                                </h6>
                            @else
                                <h6 class="fw-bold text-success ms-1">
                                    ₱{{ number_format($transactions->motors->price_installment - $transactions->getTotalAmountAttribute(), 2, '.', ',') }}
                                </h6>
                            @endif
                        </div>
                        <div class="d-flex mt-1  justify-content-between align-items-center">
                            <h6>Total amount dues</h6>
                            <h6 class="fw-bold text-success ms-1 m-0">₱{{ number_format($transactions->monthly_due) }}
                            </h6>
                        </div>

                        <hr />

                    </div>
                </div>
                <div class="col-md-5 col-lg-4 col-xl-6 pt-5">
                    {{-- <div class="p-3 bg-body-tertiary" id="order">
                <h1 class="text-center mb-0">Vismotors Corp.</h1>
                <p class="text-center mb-0"> <i >{{ date('F j, Y') }}</i></p>
                <p class="text-center mb-4 "><b>OR00000</b></p>
             
              <div class="d-flex justify-content-between mt-2">
                <span class="fw-bold">{{ $motor->brand->name }} {{ $motor->modelnameyear() }} - {{ $transactions->motors->color }}</span> <span>₱186.86</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Contract no :</span> <span>{{ $transactions->ref_no }}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Account Name</span> <span>{{$transactions->customers->fullname() }}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Payment plan</span> <span>{{ $transactions->transaction_types->name }}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Downpayment</span> <span>{{$transactions->downpayment}}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Interest</span> <span>{{$transactions->motors->interest_rate}}%</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Loan Term</span> <span>{{$transactions->loan_tenure_months}} months</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Due date</span> <span>{{$transactions->due_date.''. getDaySuffix($transactions->due_date)}}</i> of the month</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span>Monthy Due</span> <span>{{$transactions->monthly_due}}</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between mt-2">
                <span class="lh-sm">Account Balance
                </span>
                <span>$40.00</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span class="lh-sm">Total amount dues</span>
                <span>$40.00</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span class="lh-sm">Payment method</span>
                <span>$40.00</span>
              </div>
              
             
              <hr />
              <div class="d-flex justify-content-between mt-2">
                <span>Total Amount paid</span> <span class="text-success">$85.00</span>
              </div>
            </div> --}}

                    <div id="mapContainer" style="height: 400px;"></div>
                </div>
            </div>
            <div style="min-height:500px">
                <h3>Payment History</h3>
                <table class="table table-striped table-bordered" id="datatable" style="width:100%; ">
                    <thead>
                        <tr>
                            <th style="width: 10%">OR#</th>
                            <th style="width: 20%">Amount</th>
                            <th style="width: 20%">Payment method</th>
                            <th style="width: 20%">Cashier</th>
                            <th style="width: 10%">Date</th>
                            <th style="width: 10%">Balance</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ($transactions->payments as $payment)
                            <tr>
                                <td>
                                    {{ $payment->or_number }}
                                </td>
                                </td>
                                <td>
                                    ₱{{ number_format($payment->amount, 2, '.', ',') }}
                                </td>
                                <td>

                                    {{ $payment->payment_method }}
                                </td>
                                <td>{{ $payment->cashier->first_name . ' ' . $payment->cashier->last_name }}</td>

                                <td>
                                    {{ formatDate($payment->created_at) }}
                                </td>

                                <td>₱{{ number_format(isset($payment->balance) ? $payment->balance : 0, 2, '.', ',') }}
                                </td>
                                <td>
                                    <div class="btn-group">

                                        <button class="btn btn-warning btn-sm"
                                            onclick="printReciept('order',{{ $payment->balance }},'{{ $payment->payment_method }}','{{ $payment->or_number }}',{{ $payment->amount }},'{{ formatDate($payment->created_at) }}')">Print</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <div class="" style="width: 500px" id="or_layout" style="display: none">
                    <div class="p-3 bg-body-tertiary" id="order">
                        <h1 class="text-center mb-0">Vismotors Corp.</h1>
                        <p class="text-center mb-0"> <i id="reciept_date">sample date</i></p>
                        <p class="text-center mb-4 "><b id="or_number">OR00000</b></p>

                        <div class="d-flex justify-content-between mt-2">

                            <span class="fw-bold">{{ $motor->brand->name }} {{ $motor->modelnameyear() }} -
                                {{ $transactions->motors->color }}</span>
                            @if ($transactions->transaction_types->name == 'Cash')
                                <span>₱{{ number_format($transactions->motors->price_cash, 2, '.', ',') }}</span>
                            @else
                                <span>₱{{ number_format($transactions->motors->price_installment, 2, '.', ',') }}</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <span>Contract no :</span> <span>{{ $transactions->ref_no }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Chassis :</span> <span>{{ $transactions->chassis }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Account Name</span> <span>{{ $transactions->customers->fullname() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Payment plan</span> <span>{{ $transactions->transaction_types->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Downpayment</span>
                            <span>₱{{ number_format($transactions->downpayment, 2, '.', ',') }}</span>
                        </div>
                        <div class=" justify-content-between mt-2"
                            style="display: {{ $transactions->transaction_types->name == 'Cash' ? 'none' : 'flex' }}">
                            <span>Interest</span> <span>{{ $transactions->motors->interest_rate }}%</span>
                        </div>
                        <div class=" justify-content-between mt-2"
                            style="display: {{ $transactions->transaction_types->name == 'Cash' ? 'none' : 'flex' }}">
                            <span>Loan Term</span> <span>{{ $transactions->loan_tenure_months }} months</span>
                        </div>
                        <div class=" justify-content-between mt-2"
                            style="display: {{ $transactions->transaction_types->name == 'Cash' ? 'none' : 'flex' }}">
                            <span>Due date</span>
                            <span>{{ $transactions->due_date . '' . getDaySuffix($transactions->due_date) }}</i> of the
                                month</span>
                        </div>
                        <div class=" justify-content-between mt-2"
                            style="display: {{ $transactions->transaction_types->name == 'Cash' ? 'none' : 'flex' }}">
                            <span>Monthy Due</span>
                            <span>₱{{ number_format($transactions->monthly_due, 2, '.', ',') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="lh-sm">Account Balance
                            </span>
                            <span id="account_balance">$40.00</span>
                        </div>
                        <div class=" justify-content-between mt-2"
                            style="display: {{ $transactions->transaction_types->name == 'Cash' ? 'none' : 'flex' }}">
                            <span class="lh-sm">Total amount dues</span>
                            <span
                                id="total_amount">₱{{ number_format($transactions->monthly_due, 2, '.', ',') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="lh-sm">Payment method</span>
                            <span id="payment_method">$40.00</span>
                        </div>


                        <hr />
                        <div class="d-flex justify-content-between mt-2">
                            <span>Total Amount paid</span> <span class="text-success"
                                id="total_amount_paid">$85.00</span>
                        </div>
                    </div>
                </div>

        </section>
    </div>

    @section('additional_css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endsection
    @section('additional_scripts')
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        @include('layouts.shared.table-scripts')
        <script>
            $(document).ready(function() {



                let map, marker;
                const lat = parseFloat(@json($transactions->customers->profile->latitude ?? null));
                const lng = parseFloat(@json($transactions->customers->profile->longitude ?? null));

                function initMap() {
                    const defaultLat = 9.299996171243155;
                    const defaultLng = 123.30301500485619;

                    const mapLat = !isNaN(lat) ? lat : defaultLat;
                    const mapLng = !isNaN(lng) ? lng : defaultLng;


                    map = L.map('mapContainer').setView([mapLat, mapLng],
                    13); // Default center coordinates and zoom level

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    marker = L.marker([mapLat, mapLng], { // Default marker position
                        draggable: true
                    }).addTo(map);

                    marker.on('dragend', function(event) {
                        updateMarkerPosition(event.target.getLatLng());
                    });
                }
                initMap()
            });

            function printReciept(divId, balance, paymentMethod, orNumber, amount, date) {
                var or_layout = document.getElementById('or_layout');
                or_layout.style.display = 'block';
                let or_number = document.getElementById('or_number');
                or_number.innerHTML = orNumber;
                let account_balance = document.getElementById('account_balance');
                account_balance.innerHTML = '₱' + balance.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let total_amount_paid = document.getElementById('total_amount_paid');
                total_amount_paid.innerHTML = '₱' + amount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let payment_method = document.getElementById('payment_method');
                payment_method.innerHTML = paymentMethod;
                let reciept_date = document.getElementById('reciept_date');
                reciept_date.innerHTML = date;
                var element = document.getElementById(divId);

                html2canvas(element).then(function(canvas) {
                    var canvasWidth = canvas.width * 2;
                    var canvasHeight = canvas.height * 2;

                    // Create a new window with the same dimensions as the canvas
                    var win = window.open('', '', `width=${canvasWidth},height=${canvasHeight}`);


                    win.document.write('<body>');
                    win.document.write('</body>');
                    win.document.body.appendChild(canvas);

                    // Ensure the canvas is fully loaded before printing
                    canvas.onload = function() {
                        win.print();
                        win.close();
                    };

                    // In some browsers, the onload event might not fire for the canvas, so use a timeout
                    setTimeout(function() {
                        win.print();
                        win.close();
                    }, 500);
                    win.onafterprint = function() {
                        or_layout.style.display = 'none';
                    };
                    win.onbeforeunload = function() {
                        or_layout.style.display = 'none';
                    }

                });
            }

            function printDiv(divId) {
                var element = document.getElementById(divId);

                html2canvas(element).then(function(canvas) {
                    var canvasWidth = canvas.width * 2;
                    var canvasHeight = canvas.height * 2;

                    // Create a new window with the same dimensions as the canvas
                    var win = window.open('', '', `width=${canvasWidth},height=${canvasHeight}`);

                    // Create a new HTML document structure
                    win.document.write('<body>');
                    win.document.write('</body>');
                    win.document.body.appendChild(canvas);
                    // Ensure the canvas is fully loaded before printing
                    canvas.onload = function() {
                        win.print();
                        win.close();
                    };

                    // In some browsers, the onload event might not fire for the canvas, so use a timeout
                    setTimeout(function() {
                        win.print();
                        win.close();
                    }, 500);
                });
            }
        </script>
    @endsection
</x-app-layout>
