<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    // Doctor - Show prescription form
    public function create(Appointment $appointment)
    {
        return view('doctor.create-prescription', compact('appointment'));
    }
    
    // Doctor - Store prescription
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required',
            'symptoms_observations' => 'required',
            'prescribed_treatment' => 'required',
            'prescribed_medicines' => 'required',
            'prescribed_pathology' => 'nullable'
        ]);
        
        $appointment = Appointment::find($request->appointment_id);
        $doctor = Doctor::where('email', Auth::user()->email)->first();
        
        Prescription::create([
            'appointment_id' => $request->appointment_id,
            'doctor_id' => $doctor->id,
            'patient_id' => $appointment->patient_id,
            'symptoms_observations' => $request->symptoms_observations,
            'prescribed_treatment' => $request->prescribed_treatment,
            'prescribed_medicines' => $request->prescribed_medicines,
            'prescribed_pathology' => $request->prescribed_pathology,
            'notes' => $request->notes
        ]);
        
        // Update appointment status to completed
        $appointment->update(['status' => 'completed']);
        
        return redirect()->route('doctor.appointments')->with('success', 'Prescription added successfully');
    }
    
    // Doctor - View all their prescriptions
    public function doctorPrescriptions()
    {
        $doctor = Doctor::where('email', Auth::user()->email)->first();
        $prescriptions = Prescription::where('doctor_id', $doctor->id)
            ->with(['patient', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('doctor.prescriptions', compact('prescriptions'));
    }
    
    // Patient - View their prescriptions
    public function patientPrescriptions()
    {
        $patient = Patient::where('email', Auth::user()->email)->first();
        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('patient.my-prescriptions', compact('prescriptions'));
    }


    // Doctor - Edit prescription
public function edit(Prescription $prescription)
{
    // Check if this prescription belongs to logged in doctor
    $doctor = Doctor::where('email', auth()->user()->email)->first();
    
    if($prescription->doctor_id != $doctor->id) {
        return redirect()->back()->with('error', 'Unauthorized access');
    }
    
    return view('doctor.edit-prescription', compact('prescription'));
}

// Doctor - Update prescription
public function update(Request $request, Prescription $prescription)
{
    $request->validate([
        'symptoms_observations' => 'required',
        'prescribed_treatment' => 'required',
        'prescribed_medicines' => 'required',
    ]);
    
    $prescription->update([
        'symptoms_observations' => $request->symptoms_observations,
        'prescribed_treatment' => $request->prescribed_treatment,
        'prescribed_medicines' => $request->prescribed_medicines,
        'prescribed_pathology' => $request->prescribed_pathology,
        'notes' => $request->notes,
    ]);
    
    return redirect()->route('doctor.prescriptions')->with('success', 'Prescription updated successfully');
}
    
    // View single prescription (print)
    public function show(Prescription $prescription)
    {
        return view('prescription.print', compact('prescription'));
    }
}