@extends('layouts.adminlte')

@section('title', 'Edit Doctor')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h3 class="card-title">Edit Doctor: {{ $doctor->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('doctors.update', $doctor) }}" method="POST" id="doctorForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $doctor->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ $doctor->email }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Phone *</label>
                    <input type="text" name="phone" class="form-control" value="{{ $doctor->phone }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Specialization *</label>
                    <input type="text" name="specialization" class="form-control" value="{{ $doctor->specialization }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Qualification *</label>
                    <input type="text" name="qualification" class="form-control" value="{{ $doctor->qualification }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Experience (Years) *</label>
                    <input type="number" name="experience_years" class="form-control" value="{{ $doctor->experience_years }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Consultation Fee *</label>
                    <input type="number" name="consultation_fee" class="form-control" value="{{ $doctor->consultation_fee }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $doctor->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $doctor->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ $doctor->address }}</textarea>
                </div>
            </div>
            
            <hr class="my-4">
            <h4>Doctor Schedule / Timings</h4>
            <p class="text-muted">Set doctor's availability for each day</p>
            
            <div class="row mt-3">
                <div class="col-12">
                    <!-- Bulk Actions -->
                    <div class="mb-3 d-flex gap-2">
                        <button type="button" id="applyToAll" class="btn btn-info btn-sm">
                            <i class="fas fa-copy"></i> Apply Monday to All Days
                        </button>
                        <button type="button" id="applyToWeekdays" class="btn btn-success btn-sm">
                            <i class="fas fa-calendar-week"></i> Apply Monday to Mon-Fri
                        </button>
                        <button type="button" id="clearAll" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Clear All Schedules
                        </button>
                    </div>
                    
                    <table class="table table-bordered" id="scheduleTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%">Day</th>
                                <th style="width: 20%">Start Time</th>
                                <th style="width: 20%">End Time</th>
                                <th style="width: 15%">Duration</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp
                            @foreach($days as $index => $day)
                            @php
                                $schedule = $doctor->schedules->where('day', $day)->first();
                            @endphp
                            <tr data-day="{{ $day }}" data-day-index="{{ $index }}">
                                <td><strong>{{ $dayNames[$index] }}</strong></td>
                                <td>
                                    <input type="time" name="schedule[{{ $day }}][start_time]" class="form-control start-time" 
                                           value="{{ $schedule ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '' }}" placeholder="--:--">
                                </td>
                                <td>
                                    <input type="time" name="schedule[{{ $day }}][end_time]" class="form-control end-time"
                                           value="{{ $schedule ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '' }}" placeholder="--:--">
                                </td>
                                <td>
                                    <input type="text" class="form-control duration-display" readonly 
                                           value="{{ $schedule ? $schedule->slot_duration . ' min' : '' }}" placeholder="Auto">
                                    <input type="hidden" name="schedule[{{ $day }}][slot_duration]" class="slot-duration" 
                                           value="{{ $schedule->slot_duration ?? 30 }}">
                                </td>
                                <td>
                                    <select name="schedule[{{ $day }}][status]" class="form-control">
                                        <option value="active" {{ ($schedule->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ ($schedule->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm clear-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="alert alert-info mt-2">
                        <i class="fas fa-info-circle"></i> 
                        <small>Duration is auto-calculated from start and end time. Leave empty if doctor is not available.</small>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Update Doctor</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // Function to calculate duration between start and end time
    function calculateDuration(startTime, endTime) {
        if(!startTime || !endTime) return null;
        
        let start = new Date(`2000-01-01 ${startTime}`);
        let end = new Date(`2000-01-01 ${endTime}`);
        
        if(end <= start) return null;
        
        let diffMinutes = (end - start) / (1000 * 60);
        return diffMinutes;
    }
    
    // Function to update duration for a row
    function updateDuration(row) {
        let startInput = row.find('.start-time');
        let endInput = row.find('.end-time');
        let durationDisplay = row.find('.duration-display');
        let durationHidden = row.find('.slot-duration');
        
        let startTime = startInput.val();
        let endTime = endInput.val();
        
        if(startTime && endTime) {
            let duration = calculateDuration(startTime, endTime);
            if(duration && duration > 0) {
                let durationMinutes = Math.floor(duration);
                durationDisplay.val(durationMinutes + ' min');
                durationHidden.val(durationMinutes >= 30 ? 30 : durationMinutes);
            } else {
                durationDisplay.val('Invalid time');
                durationHidden.val('');
            }
        } else {
            durationDisplay.val('');
            durationHidden.val('');
        }
    }
    
    // Function to clear a single row
    function clearRow(row) {
        row.find('.start-time').val('');
        row.find('.end-time').val('');
        row.find('.duration-display').val('');
        row.find('.slot-duration').val(30);
        row.find('select[name*="[status]"]').val('active');
    }
    
    // Calculate duration on time change
    $(document).on('change', '.start-time, .end-time', function() {
        let row = $(this).closest('tr');
        updateDuration(row);
    });
    
    // Calculate for all rows on page load
    $('#scheduleTable tbody tr').each(function() {
        updateDuration($(this));
    });
    
    // Apply Monday schedule to Mon-Fri (Tuesday to Friday)
    $('#applyToWeekdays').click(function() {
        let mondayRow = $('#scheduleTable tbody tr').filter(function() {
            return $(this).data('day') === 'monday';
        });
        
        let startTime = mondayRow.find('.start-time').val();
        let endTime = mondayRow.find('.end-time').val();
        let status = mondayRow.find('select[name*="[status]"]').val();
        
        if(!startTime || !endTime) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please set Monday schedule first',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        $('#scheduleTable tbody tr').each(function() {
            let day = $(this).data('day');
            
            if(day === 'monday') {
                // Skip Monday itself
                return;
            }
            
            if(day === 'tuesday' || day === 'wednesday' || day === 'thursday' || day === 'friday') {
                // Apply Monday schedule to weekdays
                $(this).find('.start-time').val(startTime);
                $(this).find('.end-time').val(endTime);
                $(this).find('select[name*="[status]"]').val(status);
                updateDuration($(this));
            } else {
                // Clear Saturday and Sunday
                clearRow($(this));
            }
        });
        
        Swal.fire({
            icon: 'success',
            title: 'Applied!',
            text: 'Monday schedule applied to Tue-Fri. Sat-Sun cleared.',
            timer: 2000,
            showConfirmButton: false
        });
    });
    
    // Apply Monday to ALL days (including Sat-Sun)
    $('#applyToAll').click(function() {
        let mondayRow = $('#scheduleTable tbody tr').filter(function() {
            return $(this).data('day') === 'monday';
        });
        
        let startTime = mondayRow.find('.start-time').val();
        let endTime = mondayRow.find('.end-time').val();
        let status = mondayRow.find('select[name*="[status]"]').val();
        
        if(!startTime || !endTime) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please set Monday schedule first',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        $('#scheduleTable tbody tr').each(function() {
            let day = $(this).data('day');
            if(day !== 'monday') {
                $(this).find('.start-time').val(startTime);
                $(this).find('.end-time').val(endTime);
                $(this).find('select[name*="[status]"]').val(status);
                updateDuration($(this));
            }
        });
        
        Swal.fire({
            icon: 'success',
            title: 'Applied!',
            text: 'Monday schedule applied to all days',
            timer: 2000,
            showConfirmButton: false
        });
    });
    
    // Clear all schedules
    $('#clearAll').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will clear all doctor schedules!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear all!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#scheduleTable tbody tr').each(function() {
                    clearRow($(this));
                });
                Swal.fire('Cleared!', 'All schedules have been cleared.', 'success');
            }
        });
    });
    
    // Clear single row
    $(document).on('click', '.clear-row', function() {
        let row = $(this).closest('tr');
        let dayName = row.find('td:first').text();
        
        Swal.fire({
            title: 'Clear schedule?',
            text: `Clear schedule for ${dayName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear'
        }).then((result) => {
            if (result.isConfirmed) {
                clearRow(row);
                Swal.fire('Cleared!', `${dayName} schedule cleared.`, 'success');
            }
        });
    });
});
</script>

<style>
    .d-flex {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    .gap-2 {
        gap: 10px;
    }
    .btn-sm {
        padding: 5px 12px;
    }
</style>
@endsection