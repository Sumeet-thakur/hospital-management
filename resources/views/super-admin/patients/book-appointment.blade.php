@extends('layouts.adminlte')

@section('title', 'Book Appointment')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Book Appointment</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patient.appointments.store') }}" method="POST">
            @csrf
            
            <div class="form-group mb-3">
                <label>Select Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }} - {{ $doctor->specialization }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mb-3">
                <label>Appointment Date</label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
            </div>
            
            <div class="form-group mb-3">
                <label>Available Time Slots</label>
                <select name="appointment_time" id="appointment_time" class="form-control" required>
                    <option value="">-- Select Doctor first --</option>
                </select>
            </div>
            
            <div class="form-group mb-3">
                <label>Symptoms</label>
                <textarea name="symptoms" class="form-control" rows="3" placeholder="Describe your symptoms"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#doctor_id').change(function() {
        var doctorId = $(this).val();
        var date = $('#appointment_date').val();
        
        if(doctorId && date) {
            $.ajax({
                url: '/get-available-slots',
                method: 'POST',
                data: {
                    doctor_id: doctorId,
                    date: date,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var slots = $('#appointment_time');
                    slots.empty();
                    slots.append('<option value="">Select Time Slot</option>');
                    
                    if(response.slots.length > 0) {
                        $.each(response.slots, function(key, slot) {
                            slots.append('<option value="' + slot + '">' + slot + '</option>');
                        });
                    } else {
                        slots.append('<option value="">No slots available</option>');
                    }
                }
            });
        }
    });
    
    $('#appointment_date').change(function() {
        $('#doctor_id').trigger('change');
    });
});
</script>
@endsection