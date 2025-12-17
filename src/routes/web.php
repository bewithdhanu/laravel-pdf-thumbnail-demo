<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfThumbnailController;



Route::get('/', [PdfThumbnailController::class, 'create'])
    ->name('pdf-thumbnail.create');

Route::post('/pdf-thumbnail', [PdfThumbnailController::class, 'store'])
    ->name('pdf-thumbnail.store');
