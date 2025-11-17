<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Freelancers;
use Livewire\Component;

class Register extends Component
{
    public $name, $email, $password;
    public function updatedEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:freelancers,email',
        ]);
    }
    public function registerUser()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:freelancers,email',
            'password' => 'required|min:6',
        ]);

        $a = new Freelancers();
        $a->name = strtolower($this->name);
        $a->email = strtolower($this->email);
        $a->password = bcrypt($this->password);
        $a->save();

        // session()->flash('success', $this->name . ", you're registered successfully!");
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
    public function render()
    {
        return view('livewire.register');
    }
}