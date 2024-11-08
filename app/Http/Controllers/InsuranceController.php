<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'provider' => 'required|string|max:255',
            'policyNumber' => 'required|string|max:255',
            'coverageType' => 'required|string|max:255',
            'validUntil' => 'required|date|after:today',
        ]);

        $insurance = Insurance::create($validated);

        return response()->json($insurance, 201);
    }

    public function update(Request $request, Insurance $insurance)
    {
        $validated = $request->validate([
            'provider' => 'required|string|max:255',
            'policyNumber' => 'required|string|max:255',
            'coverageType' => 'required|string|max:255',
            'validUntil' => 'required|date|after:today',
        ]);

        $insurance->update($validated);

        return response()->json($insurance, 200);
    }
}
