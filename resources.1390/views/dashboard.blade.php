@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content')
<style>
    .stat-card {
        border-radius: 20px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .stat-icon {
        position: absolute;
        right: 20px;
        bottom: 15px;
        font-size: 4rem;
        opacity: 0.15;
    }
    .recent-table tr {
        transition: all 0.2s;
    }
    .recent-table tr:hover {
        background: #f8f9ff;
    }
    .widget-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    .trend-up {
        color: #10b981;
        font-size: 0.75rem;
    }
</style>

<div class="row">
    <!-- Stats Row -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm bg-gradient-primary text-white">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h6 class="widget-title mb-2">TOTAL DOCTORS</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\Doctor::count() }}</h2>
                <small class="mt-2 d-block">Active Medical Staff</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm bg-gradient-success text-white">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h6 class="widget-title mb-2">TOTAL PATIENTS</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\Patient::count() }}</h2>
                <small class="mt-2 d-block">Registered Patients</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm bg-gradient-warning text-white">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h6 class="widget-title mb-2">TOTAL APPOINTMENTS</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\Appointment::count() }}</h2>
                <small class="mt-2 d-block">All Time</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm bg-gradient-danger text-white">
            <div class="card-body position-relative">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <h6 class="widget-title mb-2">TODAY'S APPOINTMENTS</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\Appointment::whereDate('appointment_date', today())->count() }}</h2>
                <small class="mt-2 d-block">{{ date('l, F j, Y') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Second Row - Quick Actions + Stats -->
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4">
                <i class="fas fa-chart-line me-2 text-primary"></i>
                <strong>Quick Stats</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Appointment Completion</span>
                        <span>
                            @php
                                $total = \App\Models\Appointment::count();
                                $completed = \App\Models\Appointment::where('status', 'completed')->count();
                                $completionRate = $total > 0 ? round(($completed / $total) * 100) : 0;
                            @endphp
                            {{ $completionRate }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Doctor Availability</span>
                        <span>
                            @php
                                $totalDocs = \App\Models\Doctor::count();
                                $activeDocs = \App\Models\Doctor::where('status', 'active')->count();
                                $activeRate = $totalDocs > 0 ? round(($activeDocs / $totalDocs) * 100) : 0;
                            @endphp
                            {{ $activeRate }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: {{ $activeRate }}%"></div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Pending Appointments</span>
                        <span>
                            @php
                                $pending = \App\Models\Appointment::where('status', 'pending')->count();
                                $pendingRate = $total > 0 ? round(($pending / $total) * 100) : 0;
                            @endphp
                            {{ $pendingRate }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $pendingRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4">
                <i class="fas fa-prescription me-2 text-success"></i>
                <strong>Prescriptions</strong>
            </div>
            <div class="card-body">
                <div class="text-center py-3">
                    <i class="fas fa-file-prescription text-success" style="font-size: 3rem;"></i>
                    <h3 class="mt-2 mb-0">{{ \App\Models\Prescription::count() }}</h3>
                    <p class="text-muted small">Total Prescriptions Issued</p>
                </div>
                <hr>
                <div class="text-center">
                    <small class="text-muted">This Month</small>
                    <h5 class="mb-0">{{ \App\Models\Prescription::whereMonth('created_at', date('m'))->count() }}</h5>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4">
                <i class="fas fa-clock me-2 text-warning"></i>
                <strong>Today's Schedule</strong>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @php
                        $todayApps = \App\Models\Appointment::with(['doctor', 'patient'])
                            ->whereDate('appointment_date', today())
                            ->limit(5)
                            ->get();
                    @endphp
                    @forelse($todayApps as $app)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-md text-primary me-2"></i>
                                <strong>{{ $app->doctor->name ?? 'N/A' }}</strong>
                                <small class="d-block text-muted">with {{ $app->patient->name ?? 'N/A' }}</small>
                            </div>
                            <span class="badge bg-info">{{ date('h:i A', strtotime($app->appointment_time)) }}</span>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-muted">No appointments today</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Third Row - Recent Records -->
<div class="row">
    <div class="col-xl-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <strong><i class="fas fa-user-md text-primary me-2"></i> Recently Joined Doctors</strong>
                <a href="{{ url('/super-admin/doctors') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover recent-table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Doctor</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Doctor::orderBy('id', 'desc')->limit(5)->get() as $doc)
                            <tr>
                                <td>
                                    <i class="fas fa-user-circle text-primary me-2"></i>
                                    {{ $doc->name }}
                                </td>
                                <td>{{ $doc->specialization }}</td>
                                <td>{{ $doc->experience_years }} years</td>
                                <td>
                                    @if($doc->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <strong><i class="fas fa-users text-success me-2"></i> Recently Registered Patients</strong>
                <a href="{{ url('/super-admin/patients') }}" class="btn btn-sm btn-outline-success">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover recent-table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Patient</th>
                                <th>Contact</th>
                                <th>Blood Group</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Patient::orderBy('id', 'desc')->limit(5)->get() as $pat)
                            <tr>
                                <td>
                                    <i class="fas fa-user-circle text-success me-2"></i>
                                    {{ $pat->name }}
                                </td>
                                <td>{{ $pat->phone }}</td>
                                <td>{{ $pat->blood_group ?? 'N/A' }}</td>
                                <td>{{ $pat->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fourth Row - Recent Appointments -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <strong><i class="fas fa-calendar-alt text-warning me-2"></i> Recent Appointments</strong>
                <a href="{{ url('/super-admin/appointments') }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover recent-table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Appointment::with(['doctor', 'patient'])->orderBy('id', 'desc')->limit(8)->get() as $app)
                            <tr>
                                <td>Dr. {{ $app->doctor->name ?? 'N/A' }}</td>
                                <td>{{ $app->patient->name ?? 'N/A' }}</td>
                                <td>{{ $app->appointment_date }} <br><small>{{ date('h:i A', strtotime($app->appointment_time)) }}</small></td>
                                <td>
                                    @if($app->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($app->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
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

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .stat-card .card-body {
        padding: 1.5rem;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
</style>
@endsection