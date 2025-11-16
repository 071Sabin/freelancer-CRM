<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Freelancers;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $admins = Freelancers::all();
        return view('livewire.dashboard', compact('admins'));
    }

    public function logout()
    {
        auth()->guard('freelancers')->logout();
        return redirect()->route('login');
    }
}