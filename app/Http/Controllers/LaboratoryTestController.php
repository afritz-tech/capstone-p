<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratoryTestController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'labTestName' => 'required|string|max:255',
            'fileURL' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $laboratoryTest = LaboratoryTest::create([
            'user_id' => auth()->id(),
            'labTestName' => $request->labTestName,
            'fileURL' => $request->fileURL,
        ]);

        return response()->json($laboratoryTest, 201);
    }

    public function update(Request $request, LaboratoryTest $laboratoryTest)
    {
        $validator = Validator::make($request->all(), [
            'labTestName' => 'required|string|max:255',
            'fileURL' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $laboratoryTest->update([
            'labTestName' => $request->labTestName,
            'fileURL' => $request->fileURL,
        ]);

        return response()->json($laboratoryTest);
    }
}