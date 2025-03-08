<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatSupportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
//set company background
Route::post('dashboard/company/background', [DashboardController::class, 'isset'])->name('dashboard.set');


//chat controller
Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
//store chat scripts
Route::post('create/chats', [ChatController::class, 'store'])->name('chats.store');
//delete chat scripts
Route::delete('chat/delete/{chat}', [ChatController::class, 'delete'])->name('chat.delete');


//Tags
Route::get('tags', [TagController::class, 'index'])->name('tags.index');
//store tag
Route::post('tags/add', [TagController::class, 'store'])->name('tag.store');
//delete tag
Route::delete('tag/delete/{tag}', [TagController::class, 'delete'])->name('tags.delete');


//gpt
Route::post('chat/support', [ChatSupportController::class, 'analyzeData'])->name('support');

Route::get('chatsupport', [ChatSupportController::class, 'index'])->name('chatsupport');

Route::post('sample', [ChatSupportController::class, 'chat'])->name('sample');

//chat support api
Route::get('chat/{token}/client/{prompt}', [ChatSupportController::class, 'chatSupportApi'])->name('chatsupport.api');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
