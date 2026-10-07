@extends('layouts.adminlte')

@section('title', 'My Appointments')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">My Appointments</h3>
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
                            @if($appointment->prescription)
                                <a href="{{ route('doctor.prescription.edit', $appointment->prescription) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit Rx
                                </a>
                                <a href="{{ route('prescription.show', $appointment->prescription) }}" class="btn btn-info btn-sm" target="_blank">
                                    <i class="fas fa-print"></i> Print
                                </a>
                            @else
                                <a href="{{ route('doctor.prescription.create', $appointment) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-prescription"></i> Add Prescription
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No appointments found.
            </div>
        @endif
    </div>
</div>
@endsection