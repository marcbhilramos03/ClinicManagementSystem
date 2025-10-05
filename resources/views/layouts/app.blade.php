<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Smart Clinic')</title>

<!-- Favicon -->
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<!-- Bootstrap 5 & FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

<style>
    html, body { height: 100%; }
    #wrapper { display: flex; min-height: 100vh; }
    .sidebar { min-height: 100vh; }
    #content-wrapper { flex: 1; display: flex; flex-direction: column; }
    #content { flex: 1; overflow-y: auto; }

    /* Rotate arrow when submenu is open */
    .sidebar .nav-link .fa-chevron-down {
        transition: transform 0.3s ease;
    }
    .sidebar .collapse.show + .nav-link .fa-chevron-down {
        transform: rotate(180deg);
    }
</style>
</head>

<body id="page-top">
@php $user = auth()->user(); @endphp

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <i class="fas fa-clinic-medical"></i>
            </div>
        </a>

        <hr class="sidebar-divider my-0">

        @php
            $currentRoute = Route::currentRouteName();
            $sidebarLinks = match($user->role) {
                'patient' => [
                    ['route'=>'patient.dashboard', 'icon'=>'fa-home', 'label'=>'Dashboard'],
                    ['route'=>'patient.appointments.index', 'icon'=>'fa-calendar', 'label'=>'Appointments'],
                    ['route'=>'patient.records', 'icon'=>'fa-notes-medical', 'label'=>'Medical Records'],
                ],
                'clinic_staff' => [
                    ['route' => 'clinic_staff.dashboard', 'icon' => 'fa-home', 'label' => 'Dashboard'],
                    [
                        'label' => 'Patient Records',
                        'icon'  => 'fa-users',
                        'submenu' => [
                            ['route' => 'clinic_staff.patients.index', 'icon' => 'fa-list', 'label' => 'All Patients'],
                            ['route' => 'clinic_staff.patients.add_medical_record', 'icon' => 'fa-notes-medical', 'label' => 'Add Medical Record'],
                            ['route' => 'clinic_staff.patients.add_vitals', 'icon' => 'fa-heartbeat', 'label' => 'Add Vitals'],
                        ]
                    ],
                    ['route' => 'clinic_staff.appointments', 'icon' => 'fa-calendar-check', 'label' => 'Appointments'],
                    [
                        'label' => 'Inventories',
                        'icon'  => 'fa-box',
                        'submenu' => [
                            ['route' => 'clinic_staff.inventories.medicine', 'icon' => 'fa-pills', 'label' => 'Medicines'],
                            ['route' => 'clinic_staff.inventories.equipment', 'icon' => 'fa-stethoscope', 'label' => 'Equipment'],
                        ]
                    ],
                ],
                'admin' => [
                    ['route'=>'admin.dashboard', 'icon'=>'fa-tachometer-alt', 'label'=>'Dashboard'],
                    ['route'=>'admin.manageUsers', 'icon'=>'fa-users', 'label'=>'Users'],
                    [
                        'label'=>'Inventory',
                        'icon'=>'fa-warehouse',
                        'submenu'=>[
                            ['route'=>'admin.inventory.medicine', 'icon'=>'fa-pills', 'label'=>'Medicine Inventory'],
                            ['route'=>'admin.inventory.equipment', 'icon'=>'fa-cogs', 'label'=>'Equipment Inventory'],
                            ['route'=>'admin.inventory.archived', 'icon'=>'fa-archive text-danger', 'label'=>'Archived Items'],
                        ]
                    ],
                    ['route'=>'admin.appointments.index', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
                ],
                default => []
            };
        @endphp

        @foreach($sidebarLinks as $index => $link)
            @if(isset($link['submenu']))
                @php
                    $submenuActive = collect($link['submenu'])->contains(fn($sublink) => $currentRoute === $sublink['route']);
                @endphp
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ $submenuActive ? '' : 'collapsed' }}" 
                       href="#" 
                       data-bs-toggle="collapse" 
                       data-bs-target="#collapse{{ $index }}" 
                       aria-expanded="{{ $submenuActive ? 'true' : 'false' }}" 
                       aria-controls="collapse{{ $index }}">
                        <div>
                            <i class="fas {{ $link['icon'] }}"></i>
                            <span>{{ $link['label'] }}</span>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div id="collapse{{ $index }}" class="collapse {{ $submenuActive ? 'show' : '' }}" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach($link['submenu'] as $sublink)
                                <a class="collapse-item {{ $currentRoute === $sublink['route'] ? 'active' : '' }}" href="{{ route($sublink['route']) }}">
                                    <i class="fas {{ $sublink['icon'] }}"></i> {{ $sublink['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
            @else
                <li class="nav-item {{ $currentRoute === $link['route'] ? 'active' : '' }}">
                    <a class="nav-link" href="{{ $link['route'] !== '#' ? route($link['route']) : '#' }}">
                        <i class="fas {{ $link['icon'] }}"></i>
                        <span>{{ $link['label'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

            <!-- Sidebar Toggle (Mobile) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Label -->
            <div class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-clinic-medical"></i>
                </div>
                <div class="sidebar-brand-text mx-3 fs-5">Smart Clinic</div>
            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ms-auto align-items-center">

                @php
                    $profileRoute = match($user->role) {
                        'admin' => route('admin.profile'),
                        'clinic_staff' => route('clinic_staff.profile.view'),
                        'patient' => route('patient.profile.view'),
                        default => '#',
                    };
                @endphp

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="img-profile rounded-circle me-2" src="{{ asset('images/profile.png') }}" style="width:40px; height:40px;">
                        <span class="d-none d-lg-inline text-gray-600 small">{{ $user->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ $profileRoute }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-key me-2"></i> Change Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>
        <!-- End Topbar -->

        <!-- Main Content -->
        <div id="content" class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- End Content Wrapper -->

</div>
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel">Confirmation</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

@stack('scripts')

</body>
</html>
