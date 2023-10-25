<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\PedidoController;
use App\Http\Controllers\Store\CartController;

Route::controller(PedidoController::class)->prefix('pedidos')->name('.pedidos')->group(function()
{
    Route::get('/{id}', 'show')->name('.show');
    Route::post('orderAfterFinishSelection', 'orderAfterFinishSelection')->name('.orderAfterFinishSelection');
});

Route::controller(CartController::class)->prefix('cart')->name('.cart')->group(function()
{
    Route::get('/getSelectCart', 'getSelectCart')->name('.show');
    Route::post('/updateCart', 'updateCart')->name('.updateCart');
});