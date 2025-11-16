<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{

    public int $count = 0;
    public $SendNews='no';

    public function increment()
    {
        $this->count++;
    }

    // This runs only when $sendNews changes
    public function updatedSendNews($value)
    {
        if ($value) {
            session()->flash('success', 'News will be sent');
        } else {
            session()->flash('success', 'News sending disabled'); // optional
        }
    }

    public function render()
    {
        return view('livewire.counter');
    }

}