<?php

namespace App\Livewire\Invoices\Settings;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.invoices-settings')]
class General extends Component
{
    public function render()
    {
        return view('livewire.invoices.settings.general');
    }
}
