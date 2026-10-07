<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f4f6f9;
        }

        /* Sidebar Styling */
        .sidebar-dark-primary {
            background: #1a2a3a !important;
        }

        .brand-link {
            background: #0d6efd !important;
            border-bottom: none !important;
        }

        .brand-text {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Remove default ugly icons */
        .nav-sidebar .nav-link>.right {
            display: none;
        }

        /* Custom accordion indicator */
        .has-treeview>a::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            float: right;
            margin-left: auto;
            transition: transform 0.3s;
        }

        .has-treeview.menu-open>a::after {
            transform: rotate(180deg);
        }

        .nav-treeview {
            margin-left: 30px;
        }

        .nav-treeview .nav-link {
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .nav-treeview .nav-link i {
            margin-right: 8px;
            font-size: 0.7rem;
        }

        /* Hover effects */
        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin: 2px 8px;
        }

        .nav-sidebar .nav-link.active {
            background: #0d6efd;
            border-radius: 8px;
            margin: 2px 8px;
        }

        /* Header styling */
        .nav-header {
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 12px 15px 5px !important;
            color: #8ba0b5 !important;
        }

        /* Card styling */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eef2f7;
            padding: 18px 20px;
        }

        /* Button styling */
        .btn {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
        }

        /* Table styling */
        .table th {
            background: #f8fafc;
            font-weight: 600;
            border-bottom: 2px solid #eef2f7;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link text-center">
    <img src="{{ asset('images/logobg.jpeg') }}" alt="Logo" style="height: 35px; display: inline-block; border-radius: 8px;">
    <span class="brand-text font-weight-bold ml-2">New Beginnings</span>
</a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if(auth()->user()->role == 'super_admin')
                            <li class="nav-header">USER MANAGEMENT</li>

                            <li class="nav-item">
                                <a href="{{ url('/super-admin/doctors') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user-md"></i>
                                    <p>Doctors</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/super-admin/patients') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Patients</p>
                                </a>
                            </li>

                            <li class="nav-header">APPOINTMENTS</li>
                            <li class="nav-item">
                                <a href="{{ url('/super-admin/appointments') }}" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>All Appointments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/super-admin/appointments/create') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Book Appointment</p>
                                </a>
                            </li>

                            <li class="nav-header">FINANCE</li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-rupee-sign"></i>
                                    <p>Billing</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Reports</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role == 'doctor')
                            <li class="nav-header">MY CLINIC</li>

                            <li class="nav-item">
                                <a href="{{ url('/doctor/appointments') }}" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-check"></i>
                                    <p>Appointments</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/doctor/prescriptions') }}" class="nav-link">
                                    <i class="nav-icon fas fa-prescription"></i>
                                    <p>Prescriptions</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role == 'user')
                            <li class="nav-header">MY HEALTH</li>

                            <li class="nav-item">
                                <a href="{{ url('/patient/book-appointment') }}" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-plus"></i>
                                    <p>Book Appointment</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/patient/appointments') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list-check"></i>
                                    <p>My Appointments</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/patient/history') }}" class="nav-link">
                                    <i class="nav-icon fas fa-folder-medical"></i>
                                    <p>Medical History</p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-header">SETTINGS</li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-key"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>&copy; 2026 New Beginnings HMS.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.datatable').DataTable();
        });

        // SweetAlert Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Global Session Messages
        @if(session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif

        @if(session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif

        @if(session('warning'))
            Toast.fire({ icon: 'warning', title: '{{ session('warning') }}' });
        @endif

        @if(session('info'))
            Toast.fire({ icon: 'info', title: '{{ session('info') }}' });
        @endif

        // Global Delete Confirmation Function
        function confirmDelete(formId, itemName = 'this item') {
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to delete ${itemName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
            return false;
        }
    </script>

    @stack('scripts')
</body>

</html>