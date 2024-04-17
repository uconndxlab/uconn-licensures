<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LicensureController;

Route::get('/', [LicensureController::class, 'index'])->name('home');
