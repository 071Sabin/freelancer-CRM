<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\InvoiceSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Register')]

class Register extends Component
{
    public $name, $email, $password, $password_confirmation;


    public function updatedEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email|max:255',
        ]);
    }
    public function registerUser()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6|max:16|confirmed',
        ]);

        $a = new User();
        $a->name = strtolower($this->name);
        $a->email = strtolower($this->email);
        $a->password = bcrypt($this->password);
        $a->save();

        InvoiceSetting::create([
            'user_id' => $a->id,
            'prefix' => 'INV',
            'next_number' => 1,
            'default_currency' => 1,
            'number_format' => '{PREFIX}{NUMBER}',
            'locale' => 'en',
            'timezone' => 'UTC',
            'default_due_days' => 14,
            'default_late_fee_type' => 'percentage',
            'default_late_fee_rate' => 0,
            'default_late_fee_amount' => 0, // Fixed amount
            'default_discount_rate' => 0,
            'default_tax_rate' => 0,
            'default_tax_inclusive' => false,
            'company_address' => [
                'line1' => '',
                'line2' => '',
                'city' => '',
                'state' => '',
                'postal_code' => '',
                'country' => ''
            ],
            'default_footer' => 'THIS IS SYSTEM GENERATED INVOICE.',
        ]);

        // session()->flash('success', $this->name . ", you're registered successfully!");
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    public function render()
    {
        // $this->users = User::all();
        return view('livewire.register');
    }
}
