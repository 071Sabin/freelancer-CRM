<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Freelancers;
use Livewire\Component;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation;
    

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
            'password' => 'required|min:6|confirmed',
        ]);

        $a = new Freelancers();
        $a->name = strtolower($this->name);
        $a->email = strtolower($this->email);
        $a->password = bcrypt($this->password);
        $a->save();

        // session()->flash('success', $this->name . ", you're registered successfully!");
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }


    public function mount()
    {
        $this->users = Freelancers::all();
    }


    public function render()
    {
        // $this->users = Freelancers::all();
        return view('livewire.register');
    }
}