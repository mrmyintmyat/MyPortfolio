<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request)
    {
        if ($request->has('isChecked')) {
            $validatedData = $request->validate([
                'settingIndex' => ['required'],
                'isChecked' => ['required', 'boolean'],
            ]);

            $user = Auth::user();
            $isChecked = $validatedData['isChecked'] === '1' ? true : false;
            $settings = $user->setting;
            $settings[$validatedData['settingIndex']] = $isChecked;
            $user->setting = $settings;
            $user->save();

            return response()->json(['success' => true]);
        }
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Update user information
        $user = auth()->user();
        if ($user->email != $request->email) {
            $user->email_verified_at = null;
            $user->status = 'user';
        }
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Handle profile image upload if provided
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('profile_logos', 'public');
            $user->logo = '/storage/' . $logoPath;
        }

        $user->save();

        // Redirect back with a success message or any other response
        return redirect('/profile?show_update_form=true')->with('success', 'Profile updated successfully.');
    }
}
