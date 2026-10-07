@extends('layouts.adminlte')

@section('title', 'My Prescriptions')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Prescriptions Given</h3>
    </div>
    <div class="card-body">
        @if(isset($prescriptions) && $prescriptions->count() > 0)
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Symptoms</th>
                        <th>Treatment</th>
                        <th>Medicines</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->patient->name ?? 'N/A' }}</td>
                        <td>{{ $prescription->created_at->format('d M Y') }}</td>
                        <td>{{ Str::limit($prescription->symptoms_observations, 30) }}</td>
                        <td>{{ Str::limit($prescription->prescribed_treatment, 30) }}</td>
                        <td>{{ Str::limit($prescription->prescribed_medicines, 30) }}</td>
                        <td>
                            <a href="{{ route('doctor.prescription.edit', $prescription) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
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
                <i class="fas fa-info-circle"></i> No prescriptions given yet.
            </div>
        @endif
    </div>
</div>
@endsection