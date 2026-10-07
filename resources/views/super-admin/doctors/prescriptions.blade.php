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
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Symptoms</th>
                        <th>Treatment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->created_at->format('d M Y') }}</td>
                        <td>{{ $prescription->patient->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($prescription->symptoms_observations, 40) }}</td>
                        <td>{{ Str::limit($prescription->prescribed_treatment, 40) }}</td>
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
            <div class="alert alert-info">No prescriptions yet.</div>
        @endif
    </div>
</div>
@endsection