<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
    
Route::get('/', function () {
    return view('auth.register');
});

Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/registration/success/{name}', [RegistrationController::class, 'registrationSuccess'])->name('registration.success');