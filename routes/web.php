<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::get('/', fn() => redirect()->route('contacts.index'));

Route::post('contacts-import', [ContactController::class, 'import'])->name('contacts.import');

Route::get('contacts', [ContactController::class, 'show'])->name('contacts.index');
Route::resource('contacts', ContactController::class);