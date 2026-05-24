<?php
// app/Http/Controllers/Backend/AdminProfileController.php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    // ── Helper: Super Admin check ────────────────────────────────────────────
    // 'super_admin' OR যে প্রথম admin (id=1) সে সব করতে পারবে
    private function isSuperAdmin(): bool
    {
        $user = Auth::user();
        return $user->role === 'super_admin' || $user->id === 1;
    }

    /**
     * Show the profile management page.
     */
    public function index()
    {
        $admins = User::whereIn('role', ['super_admin', 'admin', 'staff'])
                      ->latest()
                      ->paginate(10);

        return view('backend.profile.index', compact('admins'));
    }

    /**
     * Update the logged-in admin's own profile info.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'  => ['nullable', 'string', 'max:20'],
            'role'   => ['required', 'in:super_admin,admin,staff'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // শুধু super_admin নিজের role পরিবর্তন করতে পারবে
        if (! $this->isSuperAdmin()) {
            unset($validated['role']);
        }

        // Avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Change the logged-in admin's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!');
    }

    /**
     * Create a new admin account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', 'in:super_admin,admin,staff'],
            'status'   => ['nullable', 'in:active,inactive'],
            'password' => ['required', Password::min(8)],
            'avatar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone']  ?? null,
            'role'     => $validated['role'],
            'status'   => $validated['status'] ?? 'active',
            'password' => Hash::make($validated['password']),
            'avatar'   => $avatarPath,
        ]);

        return back()->with('success', 'New admin account created successfully!');
    }

    /**
     * Update another admin's account.
     */
    public function adminUpdate(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($admin->id)],
            'phone'  => ['nullable', 'string', 'max:20'],
            'role'   => ['required', 'in:super_admin,admin,staff'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        $admin->update($validated);

        return back()->with('success', "{$admin->name}'s profile updated.");
    }

    /**
     * Delete an admin account (cannot delete self).
     */
    public function destroy(User $admin)
    {
        if ($admin->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $admin->delete();

        return back()->with('success', 'Admin account deleted successfully.');
    }
}