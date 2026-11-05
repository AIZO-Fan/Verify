<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile page.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    /**
     * Update the authenticated user's profile information.
     * Supports optional password change with current password verification.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ];

        // Only validate password fields if the user is trying to change their password
        if ($request->filled('new_password')) {
            $rules['current_password'] = ['required', 'string'];
            $rules['new_password']     = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $request->validate($rules);

        // Verify current password if attempting to change password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password you entered is incorrect.',
                ])->withInput();
            }
        }

        // Update basic profile info
        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // Update password only if provided and verified
        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
