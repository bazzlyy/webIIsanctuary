<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // upload foto
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

        

    $user->update([
        'name' => $request->name,
        'nickname' => $request->nickname,
        'bio' => $request->bio,
    ]);

    return back()->with('success', 'Profile updated!');
}

       public function updateProfile (Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'avatar' => 'nullable|image'
    ]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'country' => $request->country,
        'city' => $request->city,
        'postal_code' => $request->postal_code
    ]);

    return back()->with('success', 'Profile updated!');
}

    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user');
    });
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    
}
