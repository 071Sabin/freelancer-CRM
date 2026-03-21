<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Client Pivot | Settings')]
class Settings extends Component
{
    use WithFileUploads;

    public $name, $email, $bio;
    public $profile_pic;

    public function mount()
    {
        $this->name = Str::title(Auth::guard('web')->user()->name);
        $this->email = Auth::guard('web')->user()->email;
        $this->bio = Auth::guard('web')->user()->bio ?? '';
    }

    public function updateInfo()
    {
        if (Auth::guard('web')->check()) {
            $freelancer = auth()->user();
            // dd($this->profile_pic);

            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'bio' => 'nullable|string|max:500',
                'profile_pic' => 'nullable|image|max:2048|mimes:jpeg,png,jpg'
            ], [
                'profile_pic.max' => 'The profile picture must not be greater than 2MB.',
                'profile_pic.mimes' => 'The profile picture must be a file of type: jpeg, png, jpg.',
            ]);

            $freelancer->name = strtolower($this->name);
            $freelancer->email = strtolower($this->email);
            $freelancer->bio = strtolower($this->bio);

            if ($this->profile_pic) {
                if ($freelancer->profile_pic) {
                    Storage::disk('local')->delete($freelancer->profile_pic);
                }
                $freelancer->profile_pic = $this->profile_pic->store('profile_pics', 'local');
            }

            $freelancer->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        }
    }

    public function connectStripe()
    {
        // Get the Client ID from our config
        $clientId = config('services.stripe.client_id');

        // Where Stripe should send them back (must match the URL in your dashboard exactly)
        $redirectUri = urlencode(url('/stripe/callback'));

        // Build the official Stripe Connect URL
        $stripeUrl = "https://connect.stripe.com/oauth/authorize?response_type=code&client_id={$clientId}&scope=read_write&redirect_uri={$redirectUri}";

        // Redirect the user to Stripe
        return redirect()->away($stripeUrl);
    }

    
    public function render()
    {
        return view('livewire.settings');
    }
}