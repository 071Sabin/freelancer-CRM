<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Register')]

class Register extends Component
{
    public $name, $email, $password, $password_confirmation;


    public function updatedEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);
    }
    public function registerUser()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $a = new User();
        $a->name = strtolower($this->name);
        $a->email = strtolower($this->email);
        $a->password = bcrypt($this->password);
        $a->save();

        // session()->flash('success', $this->name . ", you're registered successfully!");
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }


    public function mount()
    {
        $this->users = User::all();
    }


    public function render()
    {
        // $this->users = User::all();
        return view('livewire.register');
    }
}