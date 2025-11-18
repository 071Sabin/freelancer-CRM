<?php

use App\Http\Controllers\registerController;
use App\Livewire\Clients;
use App\Livewire\Counter;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Settings;
use App\Livewire\Userentry;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

Route::middleware('auth:freelancers')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/clients', Clients::class)->name('clients');
    

    Route::get('/settings', Settings::class)->name('settings');
    Route::post('/logout', [Dashboard::class, 'logout'])->name('logout');
});