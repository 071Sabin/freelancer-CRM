<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $admins = User::all();
        $totalClients = Client::count();
        return view('livewire.dashboard', compact('admins', 'totalClients'));
    }

    public function logout()
    {
        Auth::guard('User')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}