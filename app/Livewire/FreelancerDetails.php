<?php

namespace App\Livewire;

use App\DataTables\FreelancersDataTable;
use App\Models\Freelancers;
use Livewire\Component;

class FreelancerDetails extends Component
{

    public $users, $sortBy = 'nameAsc';

    public function sortByName()
    {
        if ($this->sortBy == 'nameAsc') {
            $this->sortBy = 'nameDesc';
            $this->users = Freelancers::orderBy('name', 'asc')->get();
        } else {
            $this->users = Freelancers::orderBy('name', 'desc')->get();
            $this->sortBy = 'nameAsc';
        }
    }


    public function render()
    {
        $this->users = Freelancers::all();
        return view('livewire.freelancer-details');
    }
}
