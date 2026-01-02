<?php

namespace App\Livewire;

use App\DataTables\UserDataTable;
use App\Models\User;
use Livewire\Component;

class FreelancerDetails extends Component
{

    public $users, $sortBy = 'nameAsc';

    public function sortByName()
    {
        if ($this->sortBy == 'nameAsc') {
            $this->sortBy = 'nameDesc';
            $this->users = User::orderBy('name', 'asc')->get();
        } else {
            $this->users = User::orderBy('name', 'desc')->get();
            $this->sortBy = 'nameAsc';
        }
    }


    public function render()
    {
        $this->users = User::all();
        return view('livewire.freelancer-details');
    }
}
