<?php

namespace App\Livewire\Invoices;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ClientPivot | Invoice')]
class Invoice extends Component
{
    public function render()
    {
        return view('livewire.invoices.invoice');
    }
}
