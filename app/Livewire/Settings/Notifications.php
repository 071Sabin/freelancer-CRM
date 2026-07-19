<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Notification Settings')]
class Notifications extends Component
{
    public function render()
    {
        return view('livewire.settings.notifications');
    }
}
