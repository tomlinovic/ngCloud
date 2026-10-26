<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'job' => ['nullable', 'string', 'max:255'],
        ]);

        $user->name = $validated['name'];
        $user->surname = $validated['surname'];
        $user->job = $validated['job'] ?? null;

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}