<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\InvoiceSetting;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Register')]

class Register extends Component
{
    public $name, $email, $password, $password_confirmation;


    public function updatedEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email|max:255',
        ]);
    }
    public function registerUser()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6|max:16|confirmed',
        ]);

        // Generate OTP and set 10 minutes expiry
        $code = (string) rand(100000, 999999);

        // Store registration info in session
        session([
            'registration_data' => [
                'name' => strtolower($this->name),
                'email' => strtolower($this->email),
                'password' => bcrypt($this->password),
            ],
            'registration_otp' => $code . '|' . now()->addMinutes(10)->timestamp,
        ]);

        // Send OTP mail to user
        Mail::to(strtolower($this->email))->send(new TwoFactorCodeMail($code));

        return redirect()->route('verify.otp')->with('success', 'Registration successful! Please verify the code sent to your email.');
    }

    public function render()
    {
        // $this->users = User::all();
        return view('livewire.register');
    }
}
