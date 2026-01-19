<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $admins, $totalClients, $progressProjects;
    public function render()
    {
        // $this->admins = User::all();
        $this->totalClients = Client::count();
        $this->progressProjects = Project::where('status', 'in-progress')->count();

        return view('livewire.dashboard');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}