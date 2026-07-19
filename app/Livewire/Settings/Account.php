<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

#[Title('Client Pivot | Account Settings')]
class Account extends Component
{
    public $confirmEmail = '';

    public function deleteAccount()
    {
        $user = Auth::user();

        // Case-sensitive exact match
        if ($this->confirmEmail !== $user->email) {
            throw ValidationException::withMessages([
                'confirmEmail' => 'The email address does not match.',
            ]);
        }

        $user->delete();

        // Logout
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Flash message and redirect
        session()->flash('success', 'Account deleted successfully.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.settings.account', [
            'userEmail' => Auth::user()->email,
        ]);
    }
}
