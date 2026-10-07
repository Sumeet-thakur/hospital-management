@extends('layouts.adminlte')

@section('title', 'Book Appointment')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Book New Appointment</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('super-admin.appointments.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Select Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }} ({{ $doctor->specialization }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Select Patient</label>
                    <select name="patient_id" class="form-control" required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Available Time Slots</label>
                    <select name="appointment_time" id="appointment_time" class="form-control" required>
                        <option value="">-- Select Doctor and Date first --</option>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label>Symptoms / Reason</label>
                    <textarea name="symptoms" class="form-control" rows="3" placeholder="Enter symptoms or reason for appointment"></textarea>
                </div>
                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Book Appointment</button>
                    <a href="{{ route('super-admin.appointments') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function loadSlots() {
        var doctorId = $('#doctor_id').val();
        var date = $('#appointment_date').val();
        
        if(doctorId && date) {
            $.ajax({
                url: '{{ route("get.available.slots") }}',
                method: 'POST',
                data: {
                    doctor_id: doctorId,
                    date: date,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var slots = $('#appointment_time');
                    slots.empty();
                    
                    if(response.slots.length > 0) {
                        slots.append('<option value="">-- Select Time Slot --</option>');
                        $.each(response.slots, function(key, slot) {
                            // Slot already in 12-hour format like "01:30 PM"
                            slots.append('<option value="' + slot + '">' + slot + '</option>');
                        });
                    } else {
                        slots.append('<option value="">No slots available</option>');
                    }
                },
                error: function() {
                    alert('Error loading slots');
                }
            });
        }
    }
    
    $('#doctor_id').change(loadSlots);
    $('#appointment_date').change(loadSlots);
});
</script>
@endsection