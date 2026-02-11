<?php

use App\Livewire\Clients\Clients;
use App\Livewire\Dashboard;
use App\Livewire\FreelancerDetails;
use App\Livewire\Invoices\Settings\Branding;
use App\Livewire\Invoices\Settings\General;
use App\Livewire\Invoices\Settings\Payments;
use App\Livewire\Login;
use App\Livewire\Projects\Projects;
use App\Livewire\Register;
use App\Livewire\Settings;

use App\Livewire\Invoices\Invoice;
use App\Livewire\Invoices\InvoiceIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:web')->group(function () {
    Route::view('/', 'welcome')->name('welcome');
    Route::view('/about', 'about')->name('about');
    Route::view('/pricing', 'pricing')->name('pricing');
});

Route::get('/register', Register::class)->name('register');

Route::get('/login', Login::class)->name('login');
// Route::get('/login', Login::class)->name('login');
// Route::get('/freelancers', FreelancerDetails::class)->name('freelancers');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/clients', Clients::class)->name('clients');
    Route::get('/projects', Projects::class)->name('projects');
    Route::get('/invoices', InvoiceIndex::class)->name('invoices');
    Route::prefix('invoices/settings')
        ->name('invoices.settings.')
        ->group(function () {
            Route::get('', General::class)->name('general');
            Route::get('/payments', Payments::class)->name('payments');
            Route::get('/branding', Branding::class)->name('branding');
        });
    
    Route::get('/settings', Settings::class)->name('settings');
    Route::post('/logout', [Dashboard::class, 'logout'])->name('logout');
    Route::get('/logout', function () {
        return redirect()->route('dashboard');
    });
});


// 