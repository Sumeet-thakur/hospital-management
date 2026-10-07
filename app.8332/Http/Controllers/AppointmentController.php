<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Super Admin - View all appointments
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();
        return view('super-admin.appointments.index', compact('appointments'));
    }

    // Super Admin - Show create appointment form
    public function createAppointment()
    {
        $doctors = Doctor::where('status', 'active')->get();
        $patients = Patient::all();
        return view('super-admin.appointments.create', compact('doctors', 'patients'));
    }

    // Super Admin - Store appointment
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'patient_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        // Convert time from "09:00 AM" to "09:00:00"
        $time = date('H:i:s', strtotime($request->appointment_time));

        // Check if slot is already booked
        $existing = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $time)
            ->first();

        if ($existing) {
            return back()->with('error', 'This time slot is already booked!');
        }

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $time,
            'symptoms' => $request->symptoms,
            'status' => 'pending'
        ]);

        return redirect()->route('super-admin.appointments')->with('success', 'Appointment booked successfully');
    }

    // Patient - Book appointment form
    public function create()
    {
        $doctors = Doctor::where('status', 'active')->get();
        return view('patient.book-appointment', compact('doctors'));
    }

    // Patient - Store appointment
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'symptoms' => 'nullable'
        ]);

        // Get patient ID (assuming patient is logged in user)
        $patient = Patient::where('email', Auth::user()->email)->first();

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'symptoms' => $request->symptoms,
            'status' => 'pending'
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully');
    }

    // Patient - View their appointments
    public function patientAppointments()
    {
        $patient = Patient::where('email', Auth::user()->email)->first();
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->get();
        return view('patient.my-appointments', compact('appointments'));
    }

    // Doctor - View their appointments
    // Doctor - View their appointments
    public function doctorAppointments()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found');
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // Update appointment status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $appointment->update(['status' => $request->status]);
        return back()->with('success', 'Appointment status updated');
    }

    // Get available time slots for a doctor on a specific date
    public function getAvailableSlots(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->date;

        // Get day name (monday, tuesday etc.)
        $day = strtolower(date('l', strtotime($date)));

        // Get doctor schedule for that day
        $schedule = \App\Models\DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day', $day)
            ->where('status', 'active')
            ->first();

        // Agar schedule nahi mila to empty slots return karo
        if (!$schedule) {
            return response()->json(['slots' => []]);
        }

        // Generate time slots
        $slots = [];
        $start = strtotime($schedule->start_time);
        $end = strtotime($schedule->end_time);
        $duration = ($schedule->slot_duration ?? 30) * 60;

        while ($start < $end) {
            $slots[] = date('h:i A', $start);
            $start += $duration;
        }

        // Remove already booked slots
        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->pluck('appointment_time')
            ->toArray();

        $availableSlots = array_diff($slots, $bookedSlots);

        return response()->json(['slots' => array_values($availableSlots)]);
    }
}