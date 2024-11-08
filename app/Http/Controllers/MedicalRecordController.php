<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'condition' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
        ]);

        $medicalRecord = MedicalRecord::create($validated);

        return response()->json([
            'message' => 'Medical record created successfully',
            'medicalRecord' => $medicalRecord
        ], 201);
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'condition' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
        ]);

        $medicalRecord->update($validated);

        return response()->json([
            'message' => 'Medical record updated successfully',
            'medicalRecord' => $medicalRecord
        ], 200);
    }
}