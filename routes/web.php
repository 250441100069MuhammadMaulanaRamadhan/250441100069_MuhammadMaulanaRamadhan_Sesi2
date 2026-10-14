<?php

use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('pesanan.index'));
Route::resource('Menu', PesananController::class);