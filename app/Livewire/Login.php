<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Login')]

class Login extends Component
{

    public $email, $password;
    public function useAuthentication()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            session()->flash('loginSuccess', 'Information Verified!');
            return redirect()->route('dashboard');
        } else {
            $this->addError('loginError', 'Invalid email or password.');
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