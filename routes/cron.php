<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Cron\Select\SecretController;

Route::prefix('select')->group(function()
{
    Route::controller(SecretController::class)->prefix('secrets')->group(function()
    {
        Route::get('/delete', 'delete');
    });
});
