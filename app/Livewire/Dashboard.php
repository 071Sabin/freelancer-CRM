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

    public function mount()
    {
        $this->totalClients = Client::where('user_id', auth()->id())->count();
        $this->progressProjects = Project::where(['user_id' => auth()->id(), 'status' => 'in_progress'])->count();
        $this->activeProjects = Project::where(['user_id' => auth()->id(), 'status' => 'active'])->count();
        $this->recentProjects = Project::with('client')->where('user_id', auth()->id())->latest()->take(3)->get();
    }
    
    public function render()
    {
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
