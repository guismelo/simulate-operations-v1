<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulateController;

/**
 * Leia o README antes de usar
 * Use este arquivo somente para rotas públicas (seusite.com/public/your-route)
 * As rotas recebem o nome de public, logo todas as rotas com ->name('.exe') se tornam `public.exe`
 */

Route::get('/', [SimulateController::class, 'index'])->name('.index')->withoutMiddleware(['auth']);
