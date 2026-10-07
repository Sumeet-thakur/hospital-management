<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    // Patient Dashboard
    public function dashboard()
    {
        $patient = Patient::where('email', Auth::user()->email)->first();
        
        $totalAppointments = Appointment::where('patient_id', $patient->id ?? 0)->count();
        $completedAppointments = Appointment::where('patient_id', $patient->id ?? 0)
            ->where('status', 'completed')->count();
        $totalPrescriptions = Prescription::where('patient_id', $patient->id ?? 0)->count();
        
        return view('patient.dashboard', compact('totalAppointments', 'completedAppointments', 'totalPrescriptions'));
    }
    
    // Patient Medical History
    public function medicalHistory()
    {
        $patient = Patient::where('email', Auth::user()->email)->first();
        
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient record not found');
        }
        
        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('patient.medical-history', compact('prescriptions', 'patient'));
    }
    
    // Super Admin - List all patients
    public function index()
    {
        $patients = Patient::all();
        return view('super-admin.patients.index', compact('patients'));
    }
    
    // Super Admin - Show create form
    public function create()
    {
        return view('super-admin.patients.create');
    }
    
    // Super Admin - Store patient
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'blood_group' => 'nullable|string|max:5',
            'medical_history' => 'nullable|string'
        ]);
        
        Patient::create($request->all());
        
        return redirect()->route('patients.index')
            ->with('success', 'Patient added successfully');
    }
    
    // Super Admin - Show edit form
    public function edit(Patient $patient)
    {
        return view('super-admin.patients.edit', compact('patient'));
    }
    
    // Super Admin - Update patient
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'blood_group' => 'nullable|string|max:5',
            'medical_history' => 'nullable|string'
        ]);
        
        $patient->update($request->all());
        
        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully');
    }
    
    // Super Admin - Delete patient
    public function destroy(Patient $patient)
    {
        $patient->delete();
        
        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully');
    }
}