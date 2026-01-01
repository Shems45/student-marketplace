<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load(['listings' => function ($q) {
            $q->latest()->take(10);
        }]);

        return view('profiles.show', compact('user'));
    }

    public function edit()
    {
        return view('profiles.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
            'birthday' => ['nullable', 'date'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_photo') && $user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->fill([
            'username' => $data['username'],
            'birthday' => $data['birthday'] ?? null,
            'bio' => $data['bio'] ?? null,
        ])->save();

        return redirect()->route('profiles.show', $user)->with('status', 'Profile updated.');
    }
}
