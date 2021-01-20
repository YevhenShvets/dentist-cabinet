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