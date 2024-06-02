<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img alt="logo icon" class="logo-icon" src="{{ asset('assets/images/logo-icon.png') }}">
		</div>
		<div>
			<h4 class="logo-text" style="color: #ffffff">Vismotor</h4>
		</div>
		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back' style="color: #df1212"></i>
		</div>
	</div>
	<ul class="metismenu" id="menu">
		<li>
			<a href="{{ route('dashboard') }}">
				<div class="parent-icon"><i class='bx bx-home-alt'></i>
				</div>
				<div class="menu-title">Dashboard</div>
			</a>
		</li>
		@if(auth()->user()->roles[0]->name !== 'staff')
		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class="bx bx-file"></i>
				</div>
				<div class="menu-title">User Management</div>
			</a>
			<ul>
				<li>
					<a href="{{ route('user.index') }}">
						<i class='bx bx-radio-circle'></i>Customer
					</a>
				</li>
				<li>
					<a href="{{ route('user.employee') }}">
						<i class='bx bx-radio-circle'></i>Employee
					</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="{{ route('transaction.index') }}">
				<div class="parent-icon"><i class='bx bx-briefcase'></i>
				</div>
				<div class="menu-title">Transaction</div>
			</a>
		</li>
		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class="bx bx-file"></i>
				</div>
				<div class="menu-title">Reports</div>
			</a>
			<ul>
				<li> <a href="{{ route('report') }}"><i class='bx bx-radio-circle'></i>Monthly Report</a>
				</li>
			</ul>
		</li>
		@endif
		@if(auth()->user()->roles[0]->name == 'admin' || auth()->user()->roles[0]->name == 'staff')
		<li class="menu-label">Setup</li>
		<li onclick="handleEditButtonClick()" >
			<a onclick="handleEditButtonClick()" class="has-arrow" >
				<div class="parent-icon"><i class='bx bx-cart'></i>
				</div>
				<div class="menu-title">Setup</div>
			</a>
			<ul>
				<li> <a href="{{ route('brand.index') }}" onclick="handleEditButtonClick()"><i class='bx bx-radio-circle'></i>Brand</a>
				</li>
				{{-- <li> <a href="{{ route('transaction_type.index') }}" onclick="handleEditButtonClick()"><i class='bx bx-radio-circle'></i>Transaction Type</a>
				</li> --}}
				<li> <a href="{{ route('motor.index') }}" onclick="handleEditButtonClick()"><i class='bx bx-radio-circle'></i>Motorcycle</a>
				</li>
				<li> <a href="{{ route('occupation.index') }}" onclick="handleEditButtonClick()"><i class='bx bx-radio-circle'></i>Occupation</a>
				</li>
				<li> <a href="{{ route('motor_color.index') }}" onclick="handleEditButtonClick()"><i class='bx bx-radio-circle'></i>Motorcycle Colors</a>
				</li>
			</ul>
		</li>
		@endif
	</ul>
	@push('scripts')
	<script>
	   

		 function handleEditButtonClick() {
	// Get the role value from the PHP variable
	const role = @json(auth()->user()->roles[0]->name);
	
	// Check if the role is 'cashier'
	if (role === 'cashier' || role === 'member') {
			event.preventDefault();
			return Notiflix.Notify.failure("You dont have enough permissions");
	} 
}
	</script>
</div>
