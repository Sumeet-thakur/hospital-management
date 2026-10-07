@extends('layouts.adminlte')

@section('title', 'Doctor Dashboard')

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
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $todayAppointments ?? 0 }}</h3>
                <p>Today's Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalPrescriptions ?? 0 }}</h3>
                <p>Prescriptions Given</p>
            </div>
            <div class="icon">
                <i class="fas fa-prescription"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">My Patients & Appointments</h3>
    </div>
    <div class="card-body">
        @if(isset($appointments) && $appointments->count() > 0)
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Symptoms</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ date('h:i A', strtotime($appointment->appointment_time)) }}</td>
                        <td>{{ Str::limit($appointment->symptoms, 30) }}</td>
                        <td>
                            @if($appointment->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($appointment->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($appointment->status != 'completed')
                                <a href="{{ route('doctor.prescription.create', $appointment) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-prescription"></i> Add Prescription
                                </a>
                            @else
                                @if($appointment->prescription)
                                    <a href="{{ route('prescription.show', $appointment->prescription) }}" class="btn btn-info btn-sm" target="_blank">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No appointments found. Patients will appear here when appointments are booked.
            </div>
        @endif
    </div>
</div>
@endsection