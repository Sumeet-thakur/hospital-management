@extends('layouts.adminlte')

@section('title', 'Edit Patient')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Edit Patient: {{ $patient->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ $patient->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ $patient->email }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone *</label>
                        <input type="text" name="phone" class="form-control" value="{{ $patient->phone }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <input type="date" name="dob" class="form-control" value="{{ $patient->dob }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gender *</label>
                        <select name="gender" class="form-control" required>
                            <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $patient->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Blood Group</label>
                        <select name="blood_group" class="form-control">
                            <option value="">Select</option>
                            <option value="A+" {{ $patient->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $patient->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $patient->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $patient->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="O+" {{ $patient->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $patient->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                            <option value="AB+" {{ $patient->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $patient->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address *</label>
                        <textarea name="address" class="form-control" rows="2" required>{{ $patient->address }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Medical History</label>
                        <textarea name="medical_history" class="form-control" rows="3">{{ $patient->medical_history }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection