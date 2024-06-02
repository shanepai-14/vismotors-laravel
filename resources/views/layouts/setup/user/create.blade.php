<x-app-layout>
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('user.index') }}">{{ $type === 'customer' ? 'Customer' : 'Employee' }}</a>
                        </li>
                        <li aria-current="page" class="breadcrumb-item active">{{ isset($user) ? 'Edit' : 'Create' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-12">
                <div class="card">

                    <div class="card-body p-4">
                        <h6 class="card-title">{{ isset($user) ? 'Edit ' . ucfirst($type) : 'Add ' . ucfirst($type) }}</h6>
                        <hr />
                        @if (isset($user))
                            <form action="{{ route('user.update', ['user' => $user->id]) }}"
                                enctype='multipart/form-data' method="post">
                                @method('put')
                            @else
                                <form action="{{ route('user.store') }}" enctype="multipart/form-data" method="post">
                        @endif
                        @csrf
                        <input class="form-control" id="type" name="type" type="hidden"
                            value='{{ $type }}'>
                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="row g-3 mb-2">
                                            <div class="col-4">
                                                <label class="form-label" for="first_name">First Name</label>
                                                <input class="form-control" id="first_name" name="first_name"
                                                    type="text"
                                                    value="{{ old('first_name', isset($user->first_name) ? $user->first_name : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="middle_name">Middle Name</label>
                                                <input class="form-control" id="middle_name" name="middle_name"
                                                    type="text"
                                                    value="{{ old('middle_name', isset($user->middle_name) ? $user->middle_name : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="last_name">Last Name</label>
                                                <input class="form-control" id="last_name" name="last_name"
                                                    type="text"
                                                    value="{{ old('last_name', isset($user->last_name) ? $user->last_name : '') }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="username">Username</label>
                                                <input class="form-control" id="username" name="username"
                                                    type="text"
                                                    value="{{ old('username', isset($user->username) ? $user->username : '') }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="email"
                                                    value="{{ old('email', isset($user->email) ? $user->email : '') }}">
                                            </div>
                                            @isset($user)
                                            @else
                                                <div class="col-6">
                                                    <label class="form-label" for="password">Password</label>
                                                    <input class="form-control" id="password" name="password"
                                                        type="password">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label" for="password_confirmation">Password
                                                        Confirmation</label>
                                                    <input class="form-control" id="password_confirmation"
                                                        name="password_confirmation" type="password">
                                                </div>
                                            @endisset
                                        </div>
                                        <hr>
                                        <div class="row  g-3 mb-2">
                                            <div class="col-4">
                                                <label class="form-label" for="phone_no">Phone No.</label>
                                                <input class="form-control" id="phone_no" name="phone_no"
                                                    type="text"
                                                    value="{{ old('phone_no', isset($user->profile->phone_no) ? $user->profile->phone_no : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="fathers_name">Fathers Name</label>
                                                <input class="form-control" id="fathers_name" name="fathers_name"
                                                    type="text"
                                                    value="{{ old('fathers_name', isset($user->profile->fathers_name) ? $user->profile->phone_no : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="mothers_name">Mothers Name</label>
                                                <input class="form-control" id="mothers_name" name="mothers_name"
                                                    type="text"
                                                    value="{{ old('mothers_name', isset($user->profile->mothers_name) ? $user->profile->phone_no : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="address_lot">Address Lot</label>
                                                <input class="form-control" id="address_lot" name="address_lot"
                                                    type="text"
                                                    value="{{ old('address_lot', isset($user->profile->address_lot) ? $user->profile->address_lot : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="address_brgy">Address Barangay</label>
                                                <input class="form-control" id="address_brgy" name="address_brgy"
                                                    type="text"
                                                    value="{{ old('address_brgy', isset($user->profile->address_brgy) ? $user->profile->address_brgy : '') }}">
                                            </div>

                                            <div class="col-4">
                                                <label class="form-label" for="address_city">City</label>
                                                <input class="form-control" id="address_city" name="address_city"
                                                    type="text"
                                                    value="{{ old('address_city', isset($user->profile->address_city) ? $user->profile->address_city : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="address_landmark">Address
                                                    Landmark</label>
                                                <input class="form-control" id="address_landmark"
                                                    name="address_landmark" type="text"
                                                    value="{{ old('address_landmark', isset($user->profile->address_landmark) ? $user->profile->address_landmark : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="address_prov">Province</label>
                                                <input class="form-control" id="address_prov" name="address_prov"
                                                    type="text"
                                                    value="{{ old('address_prov', isset($user->profile->address_prov) ? $user->profile->address_prov : '') }}">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="email">Gender</label>
                                                <select class="form-select" id="gender_id" name="gender_id">
                                                    <option selected value="">--Select--</option>
                                                    @foreach ($gender as $gen)
                                                        <option
                                                            {{ old('gender_id', isset($user) && $user->profile->gender_id == $gen->id ? 'selected' : '') }}
                                                            value="{{ $gen->id }}">
                                                            {{ $gen->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="email">Citizenship</label>
                                                <select class="form-select" id="citizenship_id"
                                                    name="citizenship_id">
                                                    <option selected value="">--Select--</option>
                                                    @foreach ($citizenship as $citizen)
                                                        <option
                                                            {{ old('citizenship_id', isset($user) && $user->profile->citizenship_id == $citizen->id ? 'selected' : '') }}
                                                            value="{{ $citizen->id }}">
                                                            {{ $citizen->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="email">Civil Status</label>
                                                <select class="form-select" id="civil_status_id"
                                                    name="civil_status_id">
                                                    <option selected value="">--Select--</option>
                                                    @foreach ($civilStatus as $civil)
                                                        <option
                                                            {{ old('civil_status_id', isset($user) && $user->profile->civil_status_id == $civil->id ? 'selected' : '') }}
                                                            value="{{ $civil->id }}">
                                                            {{ $civil->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="email">Occupation</label>
                                                <select class="form-select" id="occupation_id" name="occupation_id">
                                                    <option selected value="">--Select--</option>
                                                    @foreach ($occupation as $work)
                                                        <option
                                                            {{ old('civil_status_id', isset($user) && $user->profile->occupation_id == $work->id ? 'selected' : '') }}
                                                            value="{{ $work->id }}">
                                                            {{ $work->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row gap-2">

                                            <div class="col-12 border border-3 p-4 rounded">
                                                <label class="form-label">Pin your address location</label>
                                                <input type="text" id="latitude" name="latitude"
                                                    value="9.299996171243155" hidden>
                                                <input type="text" id="longitude" name="longitude"
                                                    value="123.30301500485619" hidden>
                                                <div id="mapContainer" style="height: 400px; z-index:0"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border border-3 p-4 rounded mb-4">
                                        <div class="row g-3 mb-2">
                                            <div class="col-12">
                                                <label class="form-label">Roles</label>
                                                @if ($type === 'employee')
                                                    @foreach ($roles as $role)
                                                        @if ($role->name !== 'member')
                                                            @if (isset($user))
                                                                @if (in_array($role->id, $arr))
                                                                    <div class="form-check">
                                                                        <input checked class="form-check-input"
                                                                            id="{{ $role->name }}" name="role[]"
                                                                            type="checkbox"
                                                                            value="{{ $role->name }}">
                                                                        <label class="form-check-label"
                                                                            for="{{ $role->name }}">
                                                                            <span
                                                                                class="text-capitalize">{{ $role->name }}</span>
                                                                        </label>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            id="{{ $role->name }}" name="role[]"
                                                                            type="checkbox"
                                                                            value="{{ $role->name }}">
                                                                        <label class="form-check-label"
                                                                            for="{{ $role->name }}">
                                                                            <span
                                                                                class="text-capitalize">{{ $role->name }}</span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                        id="{{ $role->name }}" name="role[]"
                                                                        type="checkbox" value="{{ $role->name }}">
                                                                    <label class="form-check-label"
                                                                        for="{{ $role->name }}">
                                                                        <span
                                                                            class="text-capitalize">{{ $role->name }}</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if ($type === 'customer')
                                                    <div class="form-check">
                                                        <input checked class="form-check-input" id="member"
                                                            name="role[]" type="checkbox" value="member" readonly>
                                                        <label class="form-check-label" for="member">
                                                            <span class="text-capitalize">member</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="border border-3 p-4 rounded mb-4">

                                        <div class="row g-3 mb-2">
                                            <div class="col-12">

                                                <label class="form-label">Profile</label>
                                                @if (isset($user->profile->profile_picture))
                                                    <div class=" align-items-center justify-content-center mb-2"
                                                        id="profile_preview" style="display:flex">
                                                        <img class="mx-auto"
                                                            src="{{ asset('storage/public/temporary_docs/' . $user->profile->profile_picture) }}"
                                                            width="200px">
                                                    </div>
                                                @endif
                                                <div class="form-check">
                                                    <input type="hidden" name="profile_temp" id="profile_temp"
                                                        value="{{ isset($user->profile->profile_picture) ? $user->profile->profile_picture : '' }}">
                                                    <input type="file" name="document" id="profile" />

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" border border-3 p-4 rounded mb-4">
                                        <div class="row g-3 mb-2">
                                            <div class="col-12">

                                                <label class="form-label">Valid ID One</label>
                                                @if (isset($user->profile->valid_one))
                                                    <div class=" align-items-center justify-content-center mb-2"
                                                        id="valid_one_preview" style="display:flex">
                                                        <img class="mx-auto"
                                                            src="{{ asset('storage/public/temporary_docs/' . $user->profile->valid_one) }}"
                                                            width="200px">
                                                    </div>
                                                @endif
                                                <div class="form-check">
                                                    <input type="hidden" name="valid_one_temp" id="valid_one_temp"
                                                        value="{{ isset($user->profile->valid_one) ? $user->profile->valid_one : '' }}">
                                                    <input type="file" name="document" id="valid_one" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" border border-3 p-4 rounded mb-4">
                                        <div class="row g-3 mb-2">
                                            <div class="col-12">
                                                <label class="form-label">Valid ID Two</label>
                                                @if (isset($user->profile->valid_two))
                                                    <div class=" align-items-center justify-content-center mb-2"
                                                        id="valid_two_preview" style="display:flex">
                                                        <img class="mx-auto"
                                                            src="{{ asset('storage/public/temporary_docs/' . $user->profile->valid_two) }}"
                                                            width="200px">
                                                    </div>
                                                @endif
                                                <div class="form-check">
                                                    <input type="hidden" name="valid_two_temp" id="valid_two_temp"
                                                        value="{{ isset($user->profile->valid_two) ? $user->profile->valid_two : '' }}">
                                                    <input type="file" name="document" id="valid_two" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" border border-3 p-4 rounded mb-4">
                                        <div class="row g-3 mb-2">
                                            <div class="col-12">
                                                <label class="form-label">Proof of Income</label>
                                                @if (isset($user->profile->valid_two))
                                                    <div class=" align-items-center justify-content-center mb-2"
                                                        id="valid_two_preview" style="display:flex">
                                                        <img class="mx-auto"
                                                            src="{{ asset('storage/public/temporary_docs/' . $user->profile->valid_two) }}"
                                                            width="200px">
                                                    </div>
                                                @endif
                                                <div class="form-check">
                                                    <input type="hidden" name="income_temp" id="income_temp"
                                                        value="{{ isset($user->profile->valid_two) ? $user->profile->valid_two : '' }}">
                                                    <input type="file" name="document" id="income" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <a class="btn btn-danger btn-sm mx-2" href="{{ route('user.index') }}">Cancel</a>
                                <button class="btn btn-primary btn-sm" type="submit">Save</button>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const profile = document.getElementById('profile');
            const valid_one = document.getElementById('valid_one');
            const valid_two = document.getElementById('valid_two');

            FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginImagePreview);
            // Get a reference to the file input element
            FilePond.create(document.querySelector('input[id="profile"]'), {
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'Only Images are allowed',
                allowFileSizeValidation: true,
                maxFileSize: '10MB', // Set maximum file size to 10MB
                labelMaxFileSizeExceeded: 'File size exceeds 10MB limit',
                labelFileProcessingError: 'File size exceeds 10MB limit',
                server: {
                    process: {
                        url: '/upload',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        onload: (response) => {
                            // Handle the server response after file upload
                            console.log(response);
                            const data = JSON.parse(response);
                            if (document.getElementById('profile_preview')) {
                                document.getElementById('profile_preview').style.display = 'none';
                            }
                            transferFolderData(data, 'profile_temp');
                            return data.folder;
                        }
                    },
                    revert: {
                        url: '/delete-temporary',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        data: (file) => {
                            // Pass the fileId as data to the revert request
                            return JSON.stringify({
                                fileId: file
                            });
                        }
                    }
                }
            });
            FilePond.create(document.querySelector('input[id="income"]'), {
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'Only Images are allowed',
                allowFileSizeValidation: true,
                maxFileSize: '10MB', // Set maximum file size to 10MB
                labelMaxFileSizeExceeded: 'File size exceeds 10MB limit',
                labelFileProcessingError: 'File size exceeds 10MB limit',
                server: {
                    process: {
                        url: '/upload',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        onload: (response) => {
                            // Handle the server response after file upload
                            console.log(response);
                            const data = JSON.parse(response);
                            // if (document.getElementById('valid_one_preview')) {
                            //     document.getElementById('valid_one_preview').style.display = 'none';
                            // }
                            // transferFolderData(data, 'valid_one_temp');
                            return data.folder;
                        }
                    },
                    revert: {
                        url: '/delete-temporary',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        data: (file) => {
                            // Pass the fileId as data to the revert request
                            return JSON.stringify({
                                fileId: file
                            });
                        }
                    }
                }

            });
            FilePond.create(document.querySelector('input[id="valid_one"]'), {
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'Only Images are allowed',
                allowFileSizeValidation: true,
                maxFileSize: '10MB', // Set maximum file size to 10MB
                labelMaxFileSizeExceeded: 'File size exceeds 10MB limit',
                labelFileProcessingError: 'File size exceeds 10MB limit',
                server: {
                    process: {
                        url: '/upload',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        onload: (response) => {
                            // Handle the server response after file upload
                            console.log(response);
                            const data = JSON.parse(response);
                            if (document.getElementById('valid_one_preview')) {
                                document.getElementById('valid_one_preview').style.display = 'none';
                            }
                            transferFolderData(data, 'valid_one_temp');
                            return data.folder;
                        }
                    },
                    revert: {
                        url: '/delete-temporary',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        data: (file) => {
                            // Pass the fileId as data to the revert request
                            return JSON.stringify({
                                fileId: file
                            });
                        }
                    }
                }

            });
            FilePond.create(document.querySelector('input[id="valid_two"]'), {
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed: 'Only Images are allowed',
                allowFileSizeValidation: true,
                maxFileSize: '10MB', // Set maximum file size to 10MB
                labelMaxFileSizeExceeded: 'File size exceeds 10MB limit',
                labelFileProcessingError: 'File size exceeds 10MB limit',
                server: {
                    process: {
                        url: '/upload',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        onload: (response) => {
                            // Handle the server response after file upload
                            console.log(response);
                            const data = JSON.parse(response);
                            if (document.getElementById('valid_two_preview')) {
                                document.getElementById('valid_two_preview').style.display = 'none';
                            }
                            transferFolderData(data, 'valid_two_temp');
                            return data.folder;
                        }
                    },
                    revert: {
                        url: '/delete-temporary',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                        },
                        data: (file) => {
                            // Pass the fileId as data to the revert request
                            return JSON.stringify({
                                fileId: file
                            });
                        }
                    }
                }

            });

			// function createFilePond(id){
			// 	FilePond.create(document.querySelector(`input[id="${id}"]`), {
            //     acceptedFileTypes: ['image/*'],
            //     labelFileTypeNotAllowed: 'Only Images are allowed',
            //     allowFileSizeValidation: true,
            //     maxFileSize: '10MB', // Set maximum file size to 10MB
            //     labelMaxFileSizeExceeded: 'File size exceeds 10MB limit',
            //     labelFileProcessingError: 'File size exceeds 10MB limit',
            //     server: {
            //         process: {
            //             url: '/upload',
            //             headers: {
            //                 'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
            //             },
            //             onload: (response) => {
            //                 // Handle the server response after file upload
            //                 console.log(response);
            //                 const data = JSON.parse(response);
            //                 if (document.getElementById('valid_two_preview')) {
            //                     document.getElementById('valid_two_preview').style.display = 'none';
            //                 }
            //                 transferFolderData(data, 'valid_two_temp');
            //                 return data.folder;
            //             }
            //         },
            //         revert: {
            //             url: '/delete-temporary',
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
            //             },
            //             data: (file) => {
            //                 // Pass the fileId as data to the revert request
            //                 return JSON.stringify({
            //                     fileId: file
            //                 });
            //             }
            //         }
            //     }

            // });
			// }

            function transferFolderData(data, id) {
                const file_location = `${data.folder}/${data.filename}`
                document.getElementById(id).value = file_location;
            }

            let map, marker;
            const lat = @json(isset($user->profile->latitude) ? $user->profile->latitude : '');
            const lng = @json(isset($user->profile->longitude) ? $user->profile->longitude : '');

            function initMap() {
                map = L.map('mapContainer').setView([lat !== '' ? lat : 9.299996171243155, lng !== '' ? lng :
                    123.30301500485619], 13); // Default center coordinates and zoom level

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                marker = L.marker([lat !== '' ? lat : 9.299996171243155, lng !== '' ? lng :
                123.30301500485619], { // Default marker position
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(event) {
                    updateMarkerPosition(event.target.getLatLng());
                });
            }

            function updateMarkerPosition(latLng) {
                document.getElementById('latitude').value = latLng.lat;
                document.getElementById('longitude').value = latLng.lng;
            }

            initMap();

			// JavaScript
document.addEventListener('click', function(event) {
  if (event.target.tagName.toLowerCase() === 'img') {
    const imageSrc = event.target.src;
    console.log('Clicked image source:', imageSrc);
    const instance = basicLightbox.create(`
    <img src="${imageSrc}" width="500">
`)

instance.show()
  }
});
        </script>
    @endpush
</x-app-layout>
