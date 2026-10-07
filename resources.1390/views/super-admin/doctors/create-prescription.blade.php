@extends('layouts.adminlte')

@section('title', 'Add Prescription')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Prescription for {{ $appointment->patient->name ?? 'Patient' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('doctor.prescription.store') }}" method="POST">
            @csrf
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
            
            <div class="form-group">
                <label>Symptoms / Observations *</label>
                <textarea name="symptoms_observations" class="form-control" rows="4" required placeholder="Enter patient symptoms and observations..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Prescribed Treatment *</label>
                <textarea name="prescribed_treatment" class="form-control" rows="3" required placeholder="Enter treatment plan..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Prescribed Medicines *</label>
                <textarea name="prescribed_medicines" class="form-control" rows="3" required placeholder="Medicine name, dosage, duration..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Prescribed Pathology Tests</label>
                <textarea name="prescribed_pathology" class="form-control" rows="2" placeholder="Any lab tests required?"></textarea>
            </div>
            
            <div class="form-group">
                <label>Additional Notes</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any additional instructions..."></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Prescription</button>
            <a href="{{ route('doctor.appointments') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection