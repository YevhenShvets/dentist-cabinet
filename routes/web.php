<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function(){
    return redirect()->route('home');
})->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/clinic/{id}', [App\Http\Controllers\HomeController::class, 'clinic'])->name('clinic');
Route::get('/contacts', [App\Http\Controllers\HomeController::class, 'contacts'])->name('contacts');
Route::post('/contacts', [App\Http\Controllers\HomeController::class, 'contacts_submit'])->name('contacts_submit');
Route::get('/dentist/{id}', [App\Http\Controllers\UserController::class, 'dentist_record'])->name('dentist_record');
Route::post('/dentist/{id}/create', [App\Http\Controllers\UserController::class, 'dentist_record_create'])->name('dentist_record_create');
Route::get('/cabinet', [App\Http\Controllers\UserController::class, 'cabinet'])->name('cabinet');
Route::post('/cabinet/feedback', [App\Http\Controllers\UserController::class, 'cabinet_feedback'])->name('cabinet_feedback');
Route::get('/cabinet/record/{id}', [App\Http\Controllers\UserController::class, 'record_info'])->name('record_info');
Route::post('/cabinet/record/{id}', [App\Http\Controllers\UserController::class, 'record_new_date'])->name('record_new_date');
Route::post('/cabinet/record/{id}/delete', [App\Http\Controllers\UserController::class, 'record_delete'])->name('record_delete');
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


    Route::get('/edit/clinic/{id}', [App\Http\Controllers\AdminController::class, 'edit_clinic'])->name('admin.edit_clinic');
    Route::post('/edit/clinic/{id}', [App\Http\Controllers\AdminController::class, 'edit_clinic_submit'])->name('admin.edit_clinic_submit');
    Route::post('/delete/clinic/', [App\Http\Controllers\AdminController::class, 'delete_clinic_submit'])->name('admin.delete_clinic_submit');
    
    Route::get('/feedbacks', [App\Http\Controllers\AdminController::class, 'show_feedbacks'])->name('admin.show_feedbacks');
    Route::post('/feedbacks', [App\Http\Controllers\AdminController::class, 'show_feedbacks_submit'])->name('admin.show_feedbacks_submit');

    Route::get('/contacts', [App\Http\Controllers\AdminController::class, 'show_contacts'])->name('admin.show_contacts');
    Route::post('/contacts', [App\Http\Controllers\AdminController::class, 'show_contacts_submit'])->name('admin.show_contacts_submit');


    Route::get('/add/dentist', [App\Http\Controllers\AdminController::class, 'add_dentist'])->name('admin.add_dentist');
    Route::post('/add/dentist', [App\Http\Controllers\AdminController::class, 'add_dentist_submit'])->name('admin.add_dentist_submit');

    Route::get('/delete/user', [App\Http\Controllers\AdminController::class, 'delete_user'])->name('admin.delete_user');
    Route::post('/delete/user', [App\Http\Controllers\AdminController::class, 'delete_user_submit'])->name('admin.delete_user_submit');

});