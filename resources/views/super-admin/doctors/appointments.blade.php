@extends('layouts.adminlte')

@section('title', 'My Appointments')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Appointments List</h3>
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
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ Str::limit($appointment->symptoms, 30) }}</td>
                        <td>
                            @if($appointment->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($appointment->status == 'confirmed')
                                <span class="badge badge-info">Confirmed</span>
                            @elseif($appointment->status == 'completed')
                                <span class="badge badge-success">Completed</span>
                            @else
                                <span class="badge badge-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            @if($appointment->status != 'completed')
                                <a href="{{ route('doctor.prescription.create', $appointment) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-prescription"></i> Add Prescription
                                </a>
                            @else
                                <span class="text-success">Completed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">No appointments found.</div>
        @endif
    </div>
</div>
@endsection