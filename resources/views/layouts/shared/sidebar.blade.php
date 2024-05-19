<div class="sidebar-wrapper" data-simplebar="true">
	<div class="sidebar-header">
		<div>
			<img alt="logo icon" class="logo-icon" src="{{ asset('assets/images/logo-icon.png') }}">
		</div>
		<div>
			<h4 class="logo-text" style="color: #df1212">Vismotor</h4>
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
		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class="bx bx-file"></i>
				</div>
				<div class="menu-title">User Management</div>
			</a>
			<ul>
				<li>
					<a href="{{ route('user.index') }}">
						<i class='bx bx-radio-circle'></i>Users
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
				<li> <a href="#"><i class='bx bx-radio-circle'></i>Monthly Report</a>
				</li>
			</ul>
		</li>
		<li class="menu-label">Setup</li>
		<li>
			<a class="has-arrow" href="javascript:;">
				<div class="parent-icon"><i class='bx bx-cart'></i>
				</div>
				<div class="menu-title">Setup</div>
			</a>
			<ul>
				<li> <a href="{{ route('brand.index') }}"><i class='bx bx-radio-circle'></i>Brand</a>
				</li>
				<li> <a href="{{ route('transaction_type.index') }}"><i class='bx bx-radio-circle'></i>Transaction Type</a>
				</li>
				<li> <a href="{{ route('motor.index') }}"><i class='bx bx-radio-circle'></i>Motorcycle</a>
				</li>
				<li> <a href="{{ route('occupation.index') }}"><i class='bx bx-radio-circle'></i>Occupation</a>
				</li>
			</ul>
		</li>
	</ul>
</div>
