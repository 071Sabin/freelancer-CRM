<?php

use App\Livewire\ClientPortal\Portal;
use App\Livewire\Clients\Clients;
use App\Livewire\Invoices\Settings\Branding;
use App\Livewire\Invoices\Settings\General;
use App\Livewire\Invoices\Settings\Payments;
use App\Livewire\Login;
use App\Livewire\Projects\Projects;
use App\Livewire\Register;
use App\Livewire\VerifyOtp;
use App\Livewire\Settings;
use App\Http\Controllers\DodoWebhookController;
use App\Http\Controllers\StripeWebhookController;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Invoices\InvoiceIndex;
use App\Livewire\Pricing;
use App\Livewire\Projects\Workspace;
use App\Livewire\Settings\StripeCallback;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:web')->group(function () {
    Route::view('/', 'welcome')->name('welcome');
    Route::view('/about', 'about')->name('about');
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
    Route::get('/verify-otp', VerifyOtp::class)->name('verify.otp');
});

// this is to catch the dodo webhook
Route::post('/webhook/dodo', [DodoWebhookController::class, 'handle']);
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle']);

Route::get('/pricing', Pricing::class)->name('pricing');

Route::get('/p/view/{uuid}', Portal::class)->name('client.portal');
// Route::get('/freelancers', FreelancerDetails::class)->name('freelancers');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/clients', Clients::class)->name('clients');
    Route::get('/projects', Projects::class)->name('projects');

    Route::get('/projects/{uuid}', Workspace::class)->name('projects.workspace');

    Route::get('/invoices', InvoiceIndex::class)->name('invoices');

    Route::prefix('invoices/settings')
        ->name('invoices.settings.')
        ->group(function () {
            Route::get('', General::class)->name('general');
            Route::get('/payments', Payments::class)->name('payments');
            Route::get('/branding', Branding::class)->name('branding');
        });

    Route::get('/settings', Settings::class)->name('settings');
    Route::get('/stripe/callback', StripeCallback::class)->name('stripe.callback');

    Route::post('/logout', [Dashboard::class, 'logout'])->name('logout');
    Route::get('/logout', function () {
        return redirect()->route('dashboard');
    });
});
