<?php

use App\Livewire\Clients\Clients;
use App\Livewire\Dashboard;
use App\Livewire\FreelancerDetails;
use App\Livewire\Login;
use App\Livewire\Projects\Projects;
use App\Livewire\Register;
use App\Livewire\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::user()){
        return redirect()->route('dashboard');
    }
    return view('welcome');

})->name('welcome');


Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
// Route::get('/login', Login::class)->name('login');
Route::get('/freelancers', FreelancerDetails::class)->name('freelancers');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/clients', Clients::class)->name('clients');
    Route::get('/projects', Projects::class)->name('projects');
    

    Route::get('/settings', Settings::class)->name('settings');
    Route::post('/logout', [Dashboard::class, 'logout'])->name('logout');
    Route::get('/logout', function () {
        return redirect()->route('dashboard');
    });
});