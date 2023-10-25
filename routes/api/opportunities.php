<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Oportunidades\UserController;

Route::controller(UserController::class)->prefix('users')->name('.users')->group(function()
{
    Route::post('/', 'store')->name('store');
});