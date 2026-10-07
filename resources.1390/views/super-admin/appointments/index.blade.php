@extends('layouts.adminlte')

@section('title', 'All Appointments')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Appointments List</h3>
        <a href="{{ route('super-admin.appointments.create') }}" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> Book Appointment
        </a>
    </div>
    <div class="card-body">
        @if(isset($appointments) && $appointments->count() > 0)
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Doctor</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Symptoms</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>Dr. {{ $appointment->doctor->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ Str::limit($appointment->symptoms, 30) }}</td>
                        <td>
                            @if($appointment->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($appointment->status == 'confirmed')
                                <span class="badge bg-info">Confirmed</span>
                            @elseif($appointment->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">No appointments found. <a href="{{ route('super-admin.appointments.create') }}">Book one now</a></div>
        @endif
    </div>
</div>
@endsection