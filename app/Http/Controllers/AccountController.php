<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use app\Models\User;

class AccountController extends Controller
{
    /**
     * Toon de accountinstellingen.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        // dd($user);
        return view('account.settings', compact('user'));
    }

    /**
     * Werk de accountinstellingen bij.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Controleer of de gebruiker is ingelogd
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om je instellingen te wijzigen.');
        }

        // Validatie van invoer
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update de gebruiker
        $user->updateUser($validated);

        return redirect()->back()->with('success', 'Instellingen bijgewerkt!');
    }
}
