<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulateController;

/**
 * Leia o README antes de usar
 * 
 * Não utilize este arquivo para criar rotas
 */

Route::get('/', [SimulateController::class, 'index'])->name('.index')->withoutMiddleware(['auth']);
Route::post('/simulate', [SimulateController::class, 'test'])->name('.test')->withoutMiddleware(['auth']);
