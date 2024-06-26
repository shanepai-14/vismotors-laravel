<x-app-layout>
    <div class="page-content">
        <!--breadcrumb-->
        <style>
            .btn-secondary-emphasis {
                background-color: #a7acb1;
            }

            .btn-success-emphasis {
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
                <form action="{{ route('status.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="transaction_id" id="transaction_id" value="">
                    <input type="hidden" name="status_id" id="status_id" value="">
                    <h3 id="desc">Are you sure you want to approve this transaction?</h3>
                    <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
                        <button type="submit" class="btn btn-lg btn-success" id="approve"
                            onclick="submitForm(2)">Approve</button>
                        <button type="submit" class="btn btn-lg btn-secondary-emphasis" id="inactive"
                            onclick="submitForm(4)">Inactive</button>
                        <span id="approve_btn" class="gap-3 flex-column">
                            <button type="submit" class="btn btn-lg btn-primary w-100"
                                onclick="submitForm(3)">Active</button>
                            <button type="submit" class="btn btn-lg btn-success w-100"
                                onclick="submitForm(5)">Paid</button>
                            <button type="submit" class="btn btn-lg btn-danger w-100"
                                onclick="submitForm(6)">Unpaid</button>
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
                                            {{ $transaction->customers->fullname() }} |
                                            
                                            <a href="#"
                                                onclick="userView('{{ json_encode($transaction->customers) }}', '{{ json_encode($transaction->customers->profile) }}')"><svg  style="height: 18px; width:18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
													<path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
													<path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
												  </svg>
												  </a>
                                        </td>
                                        <td>
                                            @php
                                                $motor = App\Models\Motor::find($transaction->motors->motor_id);
                                            @endphp
                                            <div class="row">
                                                <div class="col-12">
                                                    <b>{{ $motor->brand->name }} {{ $motor->modelnameyear() }} -
                                                        {{ $transaction->motors->color }}</b>
                                                </div>
                                                <div class="col-12">
                                                    <b>Payment Type:</b>
                                                    <i>{{ $transaction->transaction_types->name }}</i>
                                                </div>
                                                @if ($transaction->trans_type_id == 2)
                                                    <div class="col-12">
                                                        <b>Monthly Payment:</b>
                                                        {{ number_format($transaction->monthly_due, 2, '.', ',') }} for
                                                        {{ $transaction->loan_tenure_months }} months
                                                    </div>
                                                @endif
                                                @if (isset($transaction->due_date) && $transaction->due_date !== '0')
                                                    <div class="col-12">
                                                        <b>Due Date : </b> every <i
                                                            class="text-danger">{{ $transaction->due_date . getDaySuffix($transaction->due_date) }}</i>
                                                        of the month
                                                    </div>
                                                @endif
                                                <div class="col-12">
                                                    @php
                                                        $bg_colors = [
                                                            'bg-success',
                                                            'bg-warning',
                                                            'bg-info',
                                                            'bg-primary',
                                                            'btn-secondary-emphasis',
                                                            'bg-success',
                                                            'bg-danger',
                                                        ];

                                                    @endphp

                                                    <span
                                                        class="badge {{ $bg_colors[$transaction->statuses->id] }}">{{ $transaction->statuses->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ formatDate($transaction->created_at) }}
                                        </td>
                                        <td>
                                            <div class="ms-auto">
                                                <div class="btn-group">
                                                    <a class="btn btn-primary btn-sm {{ $transaction->statuses->name == 'Pending' ? 'd-none' : '' }}"
                                                        href="{{ route('transaction.edit', ['transaction' => $transaction]) }}"
                                                        onclick="handleEditButtonClick('{{ $transaction->statuses->name }}')"
                                                        id="edit_btn">Edit</a>
                                                    <a class="btn btn-warning btn-sm"
                                                        href="{{ route('payment.transaction', ['transaction' => $transaction]) }}"
                                                        onclick="handleEditButtonClick('{{ $transaction->statuses->name }}')"
                                                        id="pay_btn">Pay</a>
                                                    <button type="button" class="btn btn-info btn-sm" id="status_btn"
                                                        onclick="approval({{ $transaction->id }},{{ $transaction->statuses->id }}); handleEditButtonClick('{{ $transaction->statuses->name }}');"
                                                        {{ $transaction->statuses->name == 'Pending' && auth()->user()->roles[0]->name == 'cashier' ? '' : 'data-bs-target=#myModal  data-bs-toggle=modal' }}>
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
 function initMap(lat,lng) {
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
                        draggable: false, //
                    }).addTo(map);

                   
                }



            function userView(user, userprofile) {
                const customers = JSON.parse(user);
                const profile = JSON.parse(userprofile);
                const occupations = [
                    "Govt. Employee",
                    "Govt. Official",
                    "Private Employee",
                    "Part Time Employee",
                    "Self Employed",
                    "Student",
                    "Unemployed"
                ];
                const citizenships = [
                    "Filipino",
                    "American",
                    "Japanese",
                    "British",
                    "German",
                    "Korean"
                ];
                const civilStatuses = [
                    "Single",
                    "Married",
                    "Widowed",
                    "Divorced"
                ];
                const instance = basicLightbox.create(`
			
	<div class="" style="width:90vw; overflow-y: scroll;  max-height: calc(100vh - 40px);">
		<div class="row bg-light p-4 text-dark" >
    <div class="col-8">
        <div class="border border-3 p-4 rounded">
            <div class="row g-3 mb-2">
                <div class="col-4">
                    <label class="form-label" for="first_name">First Name</label> : 
                    <i class="mb-0">${customers.first_name}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="middle_name">Middle Name</label> : 
                    <i class="mb-0">${customers.middle_name}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="last_name">Last Name</label> : 
                    <i class="mb-0">${customers.last_name}</i>
                </div>
                <div class="col-6">
                    <label class="form-label" for="username">Username</label> : 
                    <i class="mb-0">${customers.username}</i>
                </div>
                <div class="col-6">
                    <label class="form-label" for="email">Email</label> : 
                    <i class="mb-0">${customers.email}</i>
                </div>
            </div>
            <hr>
            <div class="row  g-3 mb-2">
                <div class="col-4">
                    <label class="form-label" for="phone_no">Phone No.</label> : 
                    <i class="mb-0">${profile.phone_no}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="fathers_name">Fathers Name</label> : 
                    <i class="mb-0">${profile.fathers_name}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="mothers_name">Mothers Name</label> : 
                    <i class="mb-0">${profile.mothers_name}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="address_lot">Address Lot</label> : 
                    <i class="mb-0">${profile.address_lot}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="address_brgy">Address Barangay</label> : 
                    <i class="mb-0">${profile.address_brgy}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="address_city">City</label> : 
                    <i class="mb-0">${profile.address_city}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="address_landmark">Address Landmark</label> : 
                    <i class="mb-0">${profile.address_landmark}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="address_prov">Province</label> : 
                    <i class="mb-0">${profile.address_prov}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="email">Gender</label> : 
                    <i class="mb-0">${profile.gender_id == 1 ? 'Male' : 'Female'}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="email">Citizenship</label> : 
                    <i class="mb-0">${citizenships[profile.citizenship_id - 1]}</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="email">Civil Status</label> : 
                    <i class="mb-0">${civilStatuses[profile.civil_status_id] }</i>
                </div>
                <div class="col-4">
                    <label class="form-label" for="email">Occupation</label> : 
                    <i class="mb-0">${occupations[profile.occupation_id - 1]}</i>
                </div>
            </div>
			<div class="row gap-2">

<div class="col-12 border border-3 p-4 rounded">
	<label class="form-label">Address location</label>

	<div id="mapContainer" style="height: 400px; z-index: 0; position: relative;" class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" tabindex="0"><div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(-149px, 0px, 0px);"><div class="leaflet-pane leaflet-tile-pane"><div class="leaflet-layer " style="z-index: 1; opacity: 1;"><div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 16; transform: translate3d(148px, 160px, 0px) scale(0.25);"></div><div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 18; transform: translate3d(0px, 0px, 0px) scale(1);"><img alt="" src="https://tile.openstreetmap.org/11/1725/970.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(117px, -10px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1726/970.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(373px, -10px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1725/971.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(117px, 246px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1726/971.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(373px, 246px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1724/970.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-139px, -10px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1727/970.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(629px, -10px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1724/971.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-139px, 246px, 0px); opacity: 1;"><img alt="" src="https://tile.openstreetmap.org/11/1727/971.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(629px, 246px, 0px); opacity: 1;"></div></div></div><div class="leaflet-pane leaflet-overlay-pane"></div><div class="leaflet-pane leaflet-shadow-pane"><img src="https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png" class="leaflet-marker-shadow leaflet-zoom-animated" alt="" style="margin-left: -12px; margin-top: -41px; width: 41px; height: 41px; transform: translate3d(234px, 210px, 0px);"></div><div class="leaflet-pane leaflet-marker-pane"><img src="https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png" class="leaflet-marker-icon leaflet-zoom-animated leaflet-interactive leaflet-marker-draggable" alt="Marker" tabindex="0" role="button" style="margin-left: -12px; margin-top: -41px; width: 25px; height: 41px; transform: translate3d(234px, 210px, 0px); z-index: 210;"></div><div class="leaflet-pane leaflet-tooltip-pane"></div><div class="leaflet-pane leaflet-popup-pane"></div><div class="leaflet-proxy leaflet-zoom-animated" style="transform: translate3d(441830px, 248530px, 0px) scale(1024);"></div></div><div class="leaflet-control-container"><div class="leaflet-top leaflet-left"><div class="leaflet-control-zoom leaflet-bar leaflet-control"><a class="leaflet-control-zoom-in" href="#" title="Zoom in" role="button" aria-label="Zoom in" aria-disabled="false"><span aria-hidden="true">+</span></a><a class="leaflet-control-zoom-out" href="#" title="Zoom out" role="button" aria-label="Zoom out" aria-disabled="false"><span aria-hidden="true">−</span></a></div></div><div class="leaflet-top leaflet-right"></div><div class="leaflet-bottom leaflet-left"></div><div class="leaflet-bottom leaflet-right"><div class="leaflet-control-attribution leaflet-control"><a href="https://leafletjs.com" title="A JavaScript library for interactive maps"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" class="leaflet-attribution-flag"><path fill="#4C7BE1" d="M0 0h12v4H0z"></path><path fill="#FFD500" d="M0 4h12v3H0z"></path><path fill="#E0BC00" d="M0 7h12v1H0z"></path></svg> Leaflet</a> <span aria-hidden="true">|</span> © <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors</div></div></div></div>
</div>
<div class="col border border-3 p-4 rounded mb-4">
	<div class="row g-3 mb-2">
		<div class="col-12">
			<label class="form-label">Proof of Income</label>
																		<div class=" align-items-center justify-content-center mb-2" id="income_preview" style="display:flex">
					<img class="mx-auto" src="https://vismotor.services/storage/public/temporary_docs/${profile.income}" width="200px">
				</div>
																
		</div>
	</div>

</div>
<div class=" col border border-3 p-4 rounded mb-4">
	<div class="row g-3 mb-2">
		<div class="col-12">
			<label class="form-label">Proof of Billing</label>
																		<div class=" align-items-center justify-content-center mb-2" id="billing_preview" style="display:flex">
					<img class="mx-auto" src="https://vismotor.services/storage/public/temporary_docs/${profile.billing}" width="200px">
				</div>
																	
		</div>
	</div>

</div>
</div>
           
        </div>
    </div>
    <div class="col-4">
        
        <div class="border border-3 p-4 rounded mb-4">
            <div class="row g-3 mb-2">
                <div class="col-12">
                  
                    <div class=" align-items-center justify-content-center mb-2" id="profile_preview" style="display:flex">
                        <img class="mx-auto" src="https://vismotor.services/storage/public/temporary_docs/${profile.profile_picture}" width="200px">
                    </div>
                
                </div>
            </div>
        </div>
        <div class=" border border-3 p-4 rounded mb-4">
            <div class="row g-3 mb-2">
                <div class="col-12">
                    <label class="form-label">Valid ID One</label> : 
                    <div class=" align-items-center justify-content-center mb-2" id="valid_one_preview" style="display:flex">
                        <img class="mx-auto" src="https://vismotor.services/storage/public/temporary_docs/${profile.valid_one}" width="200px">
                    </div>
       
                </div>
            </div>
        </div>
        <div class=" border border-3 p-4 rounded mb-4">
            <div class="row g-3 mb-2">
                <div class="col-12">
                    <label class="form-label">Valid ID Two</label> : 
                    <div class=" align-items-center justify-content-center mb-2" id="valid_two_preview" style="display:flex">
                        <img class="mx-auto" src="https://vismotor.services/storage/public/temporary_docs/${profile.valid_two}" width="200px">
                    </div>
                </div>
            </div>
        </div>
       
	</div>        
                   
		</div>
				`)
               
                instance.show()
				initMap(profile.latitude,profile.longitude)
			
              
            }

            function handleEditButtonClick(status) {
                // Get the role value from the PHP variable
                const role = @json(auth()->user()->roles[0]->name);

                // Check if the role is 'cashier'
                if (role === 'cashier' || role === 'member') {

                    if (status === 'Pending') {
                        event.preventDefault();
                        return Notiflix.Notify.info("Waiting for admin aprroval.");
                    }

                }
            }
        </script>
    @endpush
    @section('additional_scripts')
        <script>
            function approval(id, status_id) {
                $('#transaction_id').val(id);
                $('#status_id').val(status_id);
                if (status_id == 2) {
                    console.log(status_id);
                    $('#approve').hide();
                    $('#desc').text('Are you sure you want to update this transaction?');
                    $('#approve_btn').css('display', 'flex');

                } else {
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
