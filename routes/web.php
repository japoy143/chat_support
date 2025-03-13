<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatSupportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

/*
ADMIN
*/

Route::middleware(['auth', 'verified'])->group(function () {
    //admin dashboard
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //admin users
    Route::get('admin/users', [AdminController::class, 'users'])->name("admin.users");

    //admin users subscribe
    Route::patch('admin/{id}/subscribe', [AdminController::class, 'subscribe'])->name('admin.users.subscribe');

    //admin inquiries for subscription
    Route::get('admin/inquiries', [AdminController::class, 'inquiries'])->name('admin.inquiries');

    //admin update status inquiries
    Route::patch('admin/inquiries/status/{inquiry}', [AdminController::class, 'statusUpdate'])->name('admin.status.update');
});

//admin register
Route::get('admin/register', [AdminAuthController::class, 'register'])->name('admin.register');

Route::post('admin/register', [AdminAuthController::class, 'store'])->name('admin.store');

//admin login
Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

Route::post('admin/login', [AdminAuthController::class, 'loginUser'])->name('admin.login_user');


/*
MAILS
*/

Route::post('sendSubscription', [EmailController::class, 'sendSubscription'])->name('send');



//dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //set company background
    Route::post('dashboard/company/background', [DashboardController::class, 'isset'])->name('dashboard.set');
});


/*
CHATS Controller
*/
Route::middleware(['auth', 'verified'])->group(function () {
    //chat controller
    Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
    //store chat scripts
    Route::post('create/chats', [ChatController::class, 'store'])->name('chats.store');
    //delete chat scripts
    Route::delete('chat/delete/{chat}', [ChatController::class, 'delete'])->name('chat.delete');
});


/*
TAGS Controller
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('tags', [TagController::class, 'index'])->name('tags.index');
    //store tag
    Route::post('tags/add', [TagController::class, 'store'])->name('tag.store');
    //delete tag
    Route::delete('tag/delete/{tag}', [TagController::class, 'delete'])->name('tags.delete');
});


/*
CHAT SUPPPORT Controller
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('chatsupport', [ChatSupportController::class, 'index'])->name('chatsupport');
    //chat support form end point
    Route::post('chatsupport/prompt', [ChatSupportController::class, 'chat'])->name('chatsupport.prompt');
    //chat support api
    Route::get('chat/{token}/client/{prompt}', [ChatSupportController::class, 'chatSupportApi'])->name('chatsupport.api');
});


/*
INTEGRATION
*/
Route::middleware(['auth', 'verified'])->group(function () {
    //integration
    Route::get('integration', [IntegrationController::class, 'index'])->name('integration');

});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
