<?php

use App\Http\Controllers\Select\ClientTextController;
use App\Http\Controllers\Select\CommentsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Select\DispatchController;
use App\Http\Controllers\Select\DownloadController;
use App\Http\Controllers\Select\GalleryController;
use App\Http\Controllers\Select\SelectionController;
use App\Http\Controllers\Select\PhotoProcessController;
use App\Http\Controllers\Select\PhotosController;
use App\Http\Controllers\Select\ClienteController;
use App\Http\Controllers\Select\RouteController;
use App\Http\Controllers\Select\LocalizationController;
use App\Http\Controllers\Select\AccessController;

Route::controller(ClientTextController::class)->prefix('clients-texts')->name('.clients-texts')->group(function()
{
    Route::get('/', 'show')->name('.show');
    Route::post('/', 'store')->name('.store');
});

Route::controller(DispatchController::class)->prefix('dispatch')->name('.dispatch')->group(function()
{
    Route::post('/', 'store')->name('.store');
    Route::post('/retryPhotos', 'retrySendDispatchPhotos')->name('.retrySendDispatchPhotos');
    Route::post('/retry', 'retryCreateZip')->name('.retryCreateZip');
    Route::post('/{id}', 'storeSendEmail')->whereNumber('id')->name('.storeSendEmail');
    Route::get('/generate', 'generate')->name('.generate');
    Route::get('/validate', 'validate')->name('.validate');
    Route::post('/delete', 'delete')->name('.delete');
});

Route::controller(DownloadController::class)->prefix('downloads')->name('.downloads')->group(function()
{
    Route::get('/', 'show')->name('.show');
    Route::get('/delete', 'delete')->name('.delete');
});

Route::controller(GalleryController::class)->prefix('gallery')->name('.gallery')->group(function()
{
    Route::get('/', 'show')->name('.show');
    Route::get('/test', 'test')->name('.test')->withoutMiddleware(['auth']);
});

Route::controller(SelectionController::class)->prefix('selections')->name('.selections')->group(function()
{
    Route::get('/getSelectionByUserAndGallery', 'getSelectionByUserAndGallery')->name('.getSelectionByUserAndGallery');
    Route::get('/{id}', 'show')->name('.show');
    Route::get('/dispatch/{accountId}', 'selectionDispatch')->name('.selectionDispatch');
});

Route::controller(PhotoProcessController::class)->prefix('photoProcess')->name('.photoProcess')->group(function()
{
    Route::get('/retryFoto/{limit}/{type}/{galleryId?}', 'retryFoto')->name('.retryFoto');
});

Route::controller(CommentsController::class)->prefix('comments')->name('.comments')->group(function()
{
    Route::post('/', 'show')->name('.show');
});

Route::controller(PhotosController::class)->prefix('photos')->name('.photos')->group(function()
{
    Route::post('/getSelectedPhotos', 'getSelectedPhotos')->name('.getSelectedPhotos');
});

Route::controller(ClienteController::class)->prefix('cliente')->name('.cliente')->group(function()
{
    Route::post('/update/{id}', 'update')->name('.update');    
});

Route::controller(RouteController::class)->prefix('route')->name('.route')->group(function(){
    Route::get('/{id}', 'getPublicRoute')->name('.getPublicRoute');
});

Route::controller(LocalizationController::class)->prefix('localization')->name('.localization')->group(function(){
    Route::get('/', 'get')->name('.get');
});

Route::controller(AccessController::class)->prefix('access')->name('.access')->group(function(){
    Route::post('/', 'store')->name('.store');
});