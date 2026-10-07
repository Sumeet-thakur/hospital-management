@extends('layouts.adminlte')

@section('title', 'Medical History')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">My Medical History</h3>
    </div>
    <div class="card-body">
        @if($prescriptions->count() > 0)
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Symptoms</th>
                        <th>Treatment</th>
                        <th>Medicines</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->created_at->format('d M Y') }}</td>
                        <td>Dr. {{ $prescription->doctor->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($prescription->symptoms_observations, 50) }}</td>
                        <td>{{ Str::limit($prescription->prescribed_treatment, 50) }}</td>
                        <td>{{ Str::limit($prescription->prescribed_medicines, 50) }}</td>
                        <td>
                            <a href="{{ route('prescription.show', $prescription) }}" class="btn btn-info btn-sm" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No medical history found. Book an appointment with a doctor.
            </div>
        @endif
    </div>
</div>
@endsection