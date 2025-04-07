<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'credentials' => "Terdapat kesalahan pada email/password"
            ]);
        }

        request()->session()->regenerate();
        // redirect
        return redirect()->route('shipments.index');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}