<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/chat/health', [ChatController::class, 'health']);
Route::post('/chat', [ChatController::class, 'message']);