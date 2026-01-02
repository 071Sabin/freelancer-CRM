<?php

use App\Http\Controllers\registerController;
use App\Livewire\Clients;
use App\Livewire\Counter;
use App\Livewire\Dashboard;
use App\Livewire\FreelancerDetails;
use App\Livewire\Login;
use App\Livewire\Projects;
use App\Livewire\Register;
use App\Livewire\Settings;
use App\Livewire\Userentry;
use App\Models\Freelancers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
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