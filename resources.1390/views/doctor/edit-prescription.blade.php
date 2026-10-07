@extends('layouts.adminlte')

@section('title', 'Edit Prescription')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Edit Prescription for {{ $prescription->patient->name ?? 'Patient' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('doctor.prescription.update', $prescription) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label>Symptoms / Observations *</label>
                <textarea name="symptoms_observations" class="form-control" rows="4" required>{{ $prescription->symptoms_observations }}</textarea>
            </div>
            
            <div class="form-group mb-3">
                <label>Prescribed Treatment *</label>
                <textarea name="prescribed_treatment" class="form-control" rows="3" required>{{ $prescription->prescribed_treatment }}</textarea>
            </div>
            
            <div class="form-group mb-3">
                <label>Prescribed Medicines *</label>
                <textarea name="prescribed_medicines" class="form-control" rows="3" required>{{ $prescription->prescribed_medicines }}</textarea>
            </div>
            
            <div class="form-group mb-3">
                <label>Prescribed Pathology Tests</label>
                <textarea name="prescribed_pathology" class="form-control" rows="2">{{ $prescription->prescribed_pathology }}</textarea>
            </div>
            
            <div class="form-group mb-3">
                <label>Additional Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ $prescription->notes }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Prescription</button>
            <a href="{{ route('doctor.prescriptions') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection