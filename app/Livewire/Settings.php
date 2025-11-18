<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Settings extends Component
{
    public string $name, $email, $bio;


    public function mount()
    {
        $this->name = Str::title(Auth::guard('freelancers')->user()->name);
        $this->email = Auth::guard('freelancers')->user()->email;
        $this->bio = Auth::guard('freelancers')->user()->bio ?? '';
    }

    public function updateInfo()
    {
        if (Auth::guard('freelancers')->check()) {
            $freelancer = Auth::guard('freelancers')->user();

            $freelancer->name = strtolower($this->name);
            $freelancer->email = strtolower($this->email);
            $freelancer->bio = strtolower($this->bio);
            $freelancer->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        }
    }
    public function render()
    {
        return view('livewire.settings');
    }
}