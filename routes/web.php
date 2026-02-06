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

Route::get('/', function () {
    if(Auth::user()){
        return redirect()->route('dashboard');
    }
    return view('welcome');

})->name('welcome');

Route::get('/about', function () {
    if(Auth::user()){
        return redirect()->route('dashboard');
    }
    return view('about');

})->name('about');


Route::get('/register', Register::class)->name('register');

Route::get('/login', Login::class)->name('login');
// Route::get('/login', Login::class)->name('login');
// Route::get('/freelancers', FreelancerDetails::class)->name('freelancers');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/clients', Clients::class)->name('clients');
    Route::get('/projects', Projects::class)->name('projects');
    Route::get('/invoices', InvoiceIndex::class)->name('invoices');
    Route::get('/invoices/{invoice}/edit', InvoiceIndex::class)->name('invoices.edit');
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