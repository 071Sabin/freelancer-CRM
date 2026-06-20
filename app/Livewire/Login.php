<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\Attributes\Title;
use Str;

#[Title('Client Pivot | Login')]

class Login extends Component
{

    public $email, $password;
    public $totalClients, $totalProjects, $totalInvoices;
    // public function useAuthentication()
    // {
    //     $credentials = $this->validate([
    //         'email' => 'required|email|max:255',
    //         'password' => 'required|min:8|max:16',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         session()->regenerate();
    //         session()->flash('loginSuccess', 'Information Verified!');
    //         return redirect()->route('dashboard');
    //     } else {
    //         $this->addError('loginError', 'Invalid email or password.');
    //     }
    // }

    public $lockoutUntil;
    public function useAuthentication()
    {
        $throttleKey = Str::transliterate(Str::lower($this->email) . '|' . request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            // Calculate the exact Unix timestamp when they are free
            $this->lockoutUntil = now()->addSeconds(RateLimiter::availableIn($throttleKey))->timestamp;
            return;
        }

        $credentials = $this->validate([
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);

            $user = Auth::user();
            if ($user->two_factor_code !== null) {
                $userId = $user->id;
                $userEmail = $user->email;

                Auth::logout();

                // Generate new OTP on login attempt for unverified user
                $code = (string) rand(100000, 999999);
                $user->two_factor_code = $code . '|' . now()->addMinutes(10)->timestamp;
                $user->save();

                Mail::to($userEmail)->send(new TwoFactorCodeMail($code));

                session(['2fa_user_id' => $userId]);

                return redirect()->route('verify.otp')->with('warning', 'Please verify the 2FA code sent to your email.');
            }

            return redirect()->route('dashboard');
        } else {
            RateLimiter::hit($throttleKey, 60);
            // Update the lockout time on a failed hit if they just crossed the limit
            if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
                $this->lockoutUntil = now()->addSeconds(RateLimiter::availableIn($throttleKey))->timestamp;
            }
            session()->flash('error', 'Invalid email or password.');
        }
    }
 
    public function mount()
    {
        if (Auth::guard('freelancers')->check()) {
            return redirect()->route('dashboard'); // works from mount
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}