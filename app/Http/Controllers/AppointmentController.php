<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date|after:today',
            'doctor' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled',
            'outcome' => 'nullable|string|max:255',
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment
        ], 201);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'date' => 'required|date|after:today',
            'doctor' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled',
            'outcome' => 'nullable|string|max:255',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $appointment
        ], 200);
    }
}