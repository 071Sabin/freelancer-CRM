<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Dashboard')]

class Dashboard extends Component
{
    public $admins, $totalClients, $progressProjects, $activeProjects, $recentProjects;


    public function render()
    {
        // $this->admins = User::all();
        $this->totalClients = Client::count();
        $this->progressProjects = Project::where('status', 'in-progress')->count();
        $this->activeProjects = Project::where('status', 'active')->count();
        $this->recentProjects = Project::with('client')->latest()->take(3)->get();
        // dd($this->recentProjects);
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
