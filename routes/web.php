<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function(){
    return view('welcome');
})->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dentist/{id}', [App\Http\Controllers\UserController::class, 'dentist_record'])->name('dentist_record');
Route::post('/dentist/{id}/create', [App\Http\Controllers\UserController::class, 'dentist_record_create'])->name('dentist_record_create');
Route::get('/cabinet', [App\Http\Controllers\UserController::class, 'cabinet'])->name('cabinet');
Route::get('/cabinet/record/{id}', [App\Http\Controllers\UserController::class, 'record_info'])->name('record_info');
Route::post('/cabinet/record/{id}/message_create', [App\Http\Controllers\UserController::class, 'message_create'])->name('message_create');
Route::get('/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings');
Route::post('/settings/update', [App\Http\Controllers\UserController::class, 'settings_update'])->name('settings_update');
Route::post('/settings/update/dentist', [App\Http\Controllers\UserController::class, 'settings_update_dentist'])->name('settings_update_dentist');


Route::prefix('admin')->middleware('guest:admin')->group(function () {                       
    Route::get('/login',  [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('admin.login');  
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'Login'])->name('admin.login.submit');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');

    Route::get('/add/clinic', [App\Http\Controllers\AdminController::class, 'add_clinic'])->name('admin.add_clinic');
    Route::post('/add/clinic', [App\Http\Controllers\AdminController::class, 'add_clinic_submit'])->name('admin.add_clinic_submit');

    Route::get('/add/dentist', [App\Http\Controllers\AdminController::class, 'add_dentist'])->name('admin.add_dentist');
    Route::post('/add/dentist', [App\Http\Controllers\AdminController::class, 'add_dentist_submit'])->name('admin.add_dentist_submit');

    Route::get('/delete/user', [App\Http\Controllers\AdminController::class, 'delete_user'])->name('admin.delete_user');
    Route::post('/delete/user', [App\Http\Controllers\AdminController::class, 'delete_user_submit'])->name('admin.delete_user_submit');

});