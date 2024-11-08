<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'phoneNumber' => 'required|string|regex:/^\d{3}-\d{3}-\d{4}$/',
        ]);

        $phoneNumber = PhoneNumber::create($validated);

        return response()->json($phoneNumber, 201);
    }

    public function update(Request $request, PhoneNumber $phoneNumber)
    {
        $validated = $request->validate([
            'phoneNumber' => 'required|string|regex:/^\d{3}-\d{3}-\d{4}$/',
        ]);

        $phoneNumber->update($validated);

        return response()->json($phoneNumber, 200);
    }
}