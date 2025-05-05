<?php

namespace App\Http\Controllers;

use App\Jobs\SendResetPasswordEmailJob;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rule;

class PasswordResetController extends Controller
{
    public function showForgotPassworForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function sendResetLink()
    {
        request()->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi. Mohon isi email anda.',
            'email.email' => 'Format email tidak valid. Pastikan format email sudah benar.'
        ]);
        
        $email = request('email');
        SendResetPasswordEmailJob::dispatch($email);

        return back()->with(['status' => 'Jika email terdaftar, tautan reset telah dikirim. Masukkan ulang email jika belum menerima pesan.']);
    }

    public function resetUserPassword()
    {
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email wajib diisi. Mohon isi email anda.',
            'email.email' => 'Format email tidak valid. Pastikan format email sudah benar.',
            'password.required' => 'Kata sandi wajib diisi. Mohon isi kata sandi baru',
            'password.min' => 'Kata sandi minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.'
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => 'Token reset tidak valid atau email tidak terdaftar.']);
    }
}