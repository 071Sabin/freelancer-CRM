<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;


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
            ]);

            $freelancer->name = strtolower($this->name);
            $freelancer->email = strtolower($this->email);
            $freelancer->bio = strtolower($this->bio);

            if ($this->profile_pic) {
                if ($freelancer->profile_pic) {
                    Storage::disk('local')->delete($freelancer->profile_pic);                   // $this->reset('profile_pics');
                }
                $freelancer->profile_pic = $this->profile_pic->store('profile_pics', 'local');

            }

            $freelancer->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        }
    }
    public function render()
    {
        return view('livewire.settings');
    }
}