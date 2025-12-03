<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Client;
use App\Models\Freelancers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $admins = Freelancers::all();
        $totalClients = Client::count();
        return view('livewire.dashboard', compact('admins', 'totalClients'));
    }

    public function logout()
    {
        Auth::guard('freelancers')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}