<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\UserInfoController;
use App\Http\Controllers\Dashboard\ContractController;
use App\Http\Controllers\Dashboard\WeddingController;

Route::controller(UserInfoController::class)->prefix('users')->name('.users')->group(function()
{
    Route::get('info/{userId}', 'show')->whereNumber('userId')->name('.show');
    Route::post('info/list', 'list')->name('list');
    Route::post('info/store', 'store')->name('.store');
    Route::post('info/update', 'update')->name('.update');
    Route::post('info/delete', 'delete')->name('.delete');
    Route::post('info/CreateOrUpdateClients', 'CreateOrUpdateClients')->name('CreateOrUpdateClients');
    Route::post('info/alterContractFlag', 'alterContractFlag')->name('alterContractFlag');
});

Route::controller(ContractController::class)->prefix('contracts')->name('.contracts')->group(function()
{
    Route::post('', 'store')->name('.store');
    Route::post('integration/store', 'integrationStore')->name('.integrationStore');
});

Route::controller(WeddingController::class)->prefix('weddingbrasil')->group(function()
{
    Route::post('', 'store')->name('.weddingbrasil');
});
