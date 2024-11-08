<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'address' => 'required|string|max:255',
        ]);

        $address = Address::create($validated);

        return response()->json($address, 201);
    }

    public function update(Request $request, Address $address)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $address->update($validated);

        return response()->json($address, 200);
    }
}