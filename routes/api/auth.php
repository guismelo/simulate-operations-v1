<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ZendeskController;

Route::controller(ZendeskController::class)->prefix('zendesk')->name('.zendesk')->group(function()
{
    Route::post('generate/jwt', 'generateJwt')->name('.generateJwt');
});
