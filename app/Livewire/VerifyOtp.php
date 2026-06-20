<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\InvoiceSetting;
use App\Models\Subscription;
use App\Enums\LateFeeType;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Client Pivot | Verify 2FA')]
class VerifyOtp extends Component
{
    public $code;
    public $userId;

    public function mount()
    {
        if (session()->has('registration_data') && session()->has('registration_otp')) {
            return;
        }

        $this->userId = session('2fa_user_id');

        if (!$this->userId) {
            return redirect()->route('login');
        }

        $user = User::find($this->userId);
        if (!$user || !$user->two_factor_code) {
            return redirect()->route('login');
        }
    }

    public function verify()
    {
        $this->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        if (session()->has('registration_data') && session()->has('registration_otp')) {
            $registrationData = session('registration_data');
            $registrationOtp = session('registration_otp');

            $parts = explode('|', $registrationOtp);
            if (count($parts) !== 2) {
                $this->addError('code', 'Invalid verification code state. Please register again.');
                return;
            }

            [$dbCode, $expiresAt] = $parts;

            if ($this->code !== $dbCode) {
                $this->addError('code', 'The verification code is incorrect.');
                return;
            }

            if (now()->timestamp > (int) $expiresAt) {
                $this->addError('code', 'The verification code has expired. Please request a new code.');
                return;
            }

            // Check if user already exists
            if (User::where('email', $registrationData['email'])->exists()) {
                $this->addError('code', 'A user with this email already exists.');
                return;
            }

            // Create User
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'password' => $registrationData['password'],
            ]);

            // Create Invoice Setting
            InvoiceSetting::create([
                'user_id' => $user->id,
                'prefix' => 'INV',
                'next_number' => 1,
                'default_currency' => 1,
                'number_format' => '{PREFIX}{NUMBER}',
                'locale' => 'en',
                'timezone' => 'UTC',
                'default_due_days' => 14,
                'default_late_fee_type' => LateFeeType::PERCENT->value,
                'default_late_fee_rate' => 0,
                'default_late_fee_amount' => 0,
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

            // Create Subscription
            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => 1,
                'status' => 'active',
                'trial_ends_at' => now()->addDays(14),
            ]);

            // Clear registration session keys
            session()->forget(['registration_data', 'registration_otp']);

            // Redirect to login page
            return redirect()->route('login')->with('success', 'Verification successful! Please log in.');
        }

        // Fallback login OTP verification
        $user = User::find($this->userId);

        if (!$user || !$user->two_factor_code) {
            session()->flash('error', 'Session expired. Please log in again.');
            return redirect()->route('login');
        }

        $parts = explode('|', $user->two_factor_code);
        if (count($parts) !== 2) {
            $this->addError('code', 'Invalid verification code state. Please request a new code.');
            return;
        }

        [$dbCode, $expiresAt] = $parts;

        if ($this->code !== $dbCode) {
            $this->addError('code', 'The verification code is incorrect.');
            return;
        }

        if (now()->timestamp > (int) $expiresAt) {
            $this->addError('code', 'The verification code has expired. Please request a new code.');
            return;
        }

        // Verification successful: Delete/clear the code in database
        $user->two_factor_code = null;
        $user->save();

        // Log the user in
        Auth::login($user);

        // Clear session tracking variables
        session()->forget('2fa_user_id');
        session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function resend()
    {
        if (session()->has('registration_data') && session()->has('registration_otp')) {
            $registrationData = session('registration_data');
            $code = (string) rand(100000, 999999);
            session(['registration_otp' => $code . '|' . now()->addMinutes(10)->timestamp]);

            Mail::to($registrationData['email'])->send(new TwoFactorCodeMail($code));

            session()->flash('success', 'A new verification code has been sent to your email.');
            return;
        }

        $user = User::find($this->userId);

        if (!$user) {
            session()->flash('error', 'Session expired. Please log in again.');
            return redirect()->route('login');
        }

        $code = (string) rand(100000, 999999);
        $user->two_factor_code = $code . '|' . now()->addMinutes(10)->timestamp;
        $user->save();

        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        session()->flash('success', 'A new 2FA code has been sent to your email.');
    }

    public function render()
    {
        return view('livewire.verify-otp');
    }
}
