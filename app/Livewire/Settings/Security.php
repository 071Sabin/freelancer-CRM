<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Security Settings')]
class Security extends Component
{
    public function render()
    {
        return view('livewire.settings.security');
    }
}
