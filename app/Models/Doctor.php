<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules()
{
    return $this->hasMany(DoctorSchedule::class);
}
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}