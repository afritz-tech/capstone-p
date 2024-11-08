<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Phone;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function updateProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'birthDate' => 'required|date',
                'email' => 'required|email|unique:users,email,' . $this->user->id,
                'profilePicture' => 'nullable|image|max:2048',
            ]);

            DB::transaction(function () use ($validated, $request) {
                if ($request->hasFile('profilePicture')) {
                    $this->updateProfilePicture($request->file('profilePicture'));
                }
                $this->user->update($validated);
            });

            return response()->json(['message' => 'Profile updated successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function uploadProfilePicture(Request $request)
    {
        try {
            $request->validate(['profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);

            if (!$request->hasFile('profile_picture')) {
                return response()->json(['success' => false, 'message' => 'No image file provided'], 400);
            }

            $path = $this->updateProfilePicture($request->file('profile_picture'));

            return response()->json([
                'success' => true,
                'message' => 'Profile picture uploaded successfully',
                'path' => Storage::url($path)
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    protected function updateProfilePicture($file)
    {
        if ($this->user->profile_picture) {
            Storage::disk('public')->delete($this->user->profile_picture);
        }

        $path = $file->store('profile-pictures', 'public');
        $this->user->update(['profile_picture' => $path]);

        return $path;
    }

    public function getAddresses()
    {
        $addresses = $this->user->addresses()->orderBy('created_at', 'desc')->get();
        return response()->json($addresses);
    }

    public function addAddress(Request $request)
    {
        try {
            $validated = $request->validate(['address' => 'required|string|max:255']);
            $address = $this->user->addresses()->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Address added successfully',
                'address' => $address
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function deleteAddress($id)
    {
        try {
            $address = Address::findOrFail($id);
            
            if ($address->user_id !== $this->user->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $address->delete();
            return response()->json(['success' => true, 'message' => 'Address deleted successfully']);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function addPhone(Request $request)
    {
        try {
            $validated = $request->validate(['phone_number' => 'required|string|max:20']);
            $phone = $this->user->phones()->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Phone number added successfully',
                'phone' => $phone
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function deletePhone($id)
    {
        try {
            $phone = Phone::findOrFail($id);
            
            if ($phone->user_id !== $this->user->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $phone->delete();
            return response()->json(['success' => true, 'message' => 'Phone number deleted successfully']);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    protected function handleException(\Exception $e)
    {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}