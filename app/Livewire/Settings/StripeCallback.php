<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class StripeCallback extends Component
{

    public function mount()
    {
        // Agar user ne Stripe page pe 'Cancel' daba diya
        if (request()->has('error')) {
            session()->flash('error', 'Stripe connection cancelled.');
            return redirect()->route('dashboard'); // Apne hisaab se route change kar lena
        }

        // Stripe ne jo 'code' bheja hai usko pakdo
        $code = request()->query('code');

        if ($code) {
            $response = Http::asForm()->post('https://connect.stripe.com/oauth/token', [
                'client_secret' => env('STRIPE_SECRET'),
                'code' => $code,
                'grant_type' => 'authorization_code',
            ]);

            if ($response->successful()) {
                $stripeData = $response->json();

                // User ke table me Stripe ID save kardo
                $user = auth()->user();
                $user->stripe_account_id = $stripeData['stripe_user_id'];
                $user->save();

                session()->flash('success', 'Stripe Connected Successfully! 🚀');
                return redirect()->route('dashboard');
            }
        }

        session()->flash('error', 'Something went wrong with Stripe.');
        return redirect()->route('dashboard');
    }
    // public function render()
    // {
    //     return view('livewire.settings.stripe-callback');
    // }


    public function render()
    {
        // Ye page kabhi dikhega hi nahi kyunki mount() redirect kar dega
        // Par Livewire ko ek dummy view chahiye hota hai
        return <<<'HTML'
        <div class="flex items-center justify-center h-screen">
            <p>Connecting to Stripe...</p>
        </div>
        HTML;
    }
}
