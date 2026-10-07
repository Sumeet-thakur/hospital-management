@extends('layouts.adminlte')

@section('title', 'Patient Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalAppointments ?? 0 }}</h3>
                <p>Total Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $completedAppointments ?? 0 }}</h3>
                <p>Completed Visits</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPrescriptions ?? 0 }}</h3>
                <p>Prescriptions</p>
            </div>
            <div class="icon">
                <i class="fas fa-prescription"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Welcome {{ Auth::user()->name }}</h3>
    </div>
    <div class="card-body">
        <p>Manage your appointments and view medical history from the sidebar.</p>
        <a href="{{ route('patient.book-appointment') }}" class="btn btn-primary">
            <i class="fas fa-calendar-plus"></i> Book New Appointment
        </a>
        <a href="{{ route('patient.history') }}" class="btn btn-info">
            <i class="fas fa-history"></i> View Medical History
        </a>
    </div>
</div>
@endsection