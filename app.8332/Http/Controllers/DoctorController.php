<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('super-admin.doctors.index', compact('doctors'));
    }
    
    public function create()
    {
        return view('super-admin.doctors.create');
    }
    
   
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
        'specialization' => 'required',
    ]);

    // Pehle user create karo
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make('password'),
        'role' => 'doctor'
    ]);
    // dd($user);


    // Phir doctor create karo with user_id
    Doctor::create([
        'user_id' => $user->id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'specialization' => $request->specialization,
        'qualification' => $request->qualification,
        'experience_years' => $request->experience_years,
        'consultation_fee' => $request->consultation_fee,
        'address' => $request->address,
        'status' => $request->status ?? 'active'
    ]);

    return redirect()->route('doctors.index')->with('success', 'Doctor added successfully');
}
    
    public function edit(Doctor $doctor)
    {
        return view('super-admin.doctors.edit', compact('doctor'));
    }
    
   public function update(Request $request, Doctor $doctor)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:doctors,email,'.$doctor->id,
        'phone' => 'required',
        'specialization' => 'required',
    ]);
    
    // Update doctor basic info
    $doctor->update($request->only([
        'name', 'email', 'phone', 'specialization', 
        'qualification', 'experience_years', 'consultation_fee', 
        'address', 'status'
    ]));
    
    // Save schedule - YEH PART SAHI KARO
    if($request->has('schedule')) {
        foreach($request->schedule as $day => $data) {
            if(isset($data['start_time']) && isset($data['end_time']) && $data['start_time'] && $data['end_time']) {
                \App\Models\DoctorSchedule::updateOrCreate(
                    ['doctor_id' => $doctor->id, 'day' => $day],
                    [
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'slot_duration' => $data['slot_duration'] ?? 30,
                        'status' => $data['status'] ?? 'active'
                    ]
                );
            } else {
                // Delete if times are empty
                \App\Models\DoctorSchedule::where('doctor_id', $doctor->id)
                    ->where('day', $day)
                    ->delete();
            }
        }
    }
    
    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully');
}
    
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }
    
public function dashboard()
{
    $user = auth()->user();
    
    // Check if user has doctor role
    if($user->role != 'doctor') {
        return redirect('/dashboard')->with('error', 'Unauthorized access');
    }
    
    // Get doctor details from doctors table using email
    $doctor = Doctor::where('email', $user->email)->first();
    
    if(!$doctor) {
        Auth::logout();
        return redirect('/login')->with('error', 'Doctor profile not found. Contact admin.');
    }
    
    // Get only this doctor's appointments
    $appointments = Appointment::where('doctor_id', $doctor->id)
        ->with(['patient', 'prescription'])
        ->orderBy('appointment_date', 'desc')
        ->get();
    
    $totalAppointments = $appointments->count();
    $totalPrescriptions = Prescription::where('doctor_id', $doctor->id)->count();
    $todayAppointments = Appointment::where('doctor_id', $doctor->id)
        ->where('appointment_date', date('Y-m-d'))
        ->count();
    
    return view('doctor.dashboard', compact('appointments', 'totalAppointments', 'totalPrescriptions', 'todayAppointments'));
}
}