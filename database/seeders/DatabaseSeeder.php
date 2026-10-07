<?php

use App\Models\DoctorSchedule;

// Doctor Schedule for Dr. Rajesh Kumar (doctor_id = 1)
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
foreach($days as $day) {
    DoctorSchedule::create([
        'doctor_id' => 1,
        'day' => $day,
        'start_time' => '09:00',
        'end_time' => '17:00',
        'slot_duration' => 30,
        'status' => 'active'
    ]);
}
