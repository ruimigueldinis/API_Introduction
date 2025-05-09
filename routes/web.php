<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayPalController;
// use Illuminate\Http\Client\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Bandeiras (Uso pelo API)

Route::get('/bandeira/{codigo?}', function( $codigo= null){
    return view('bandeira.bandeira', ['codigo' => $codigo ? strtoupper($codigo): null]);
})->where('codigo', '[A-Za-z]{2}')->name('bandeira');

Route::get('form-bandeira', function( ){
    return view('bandeira.form-bandeira');
});

// Requisição HTTP, contém dados enviados pelo form.
Route::post('form-bandeira', function(Request $request ){
    return view('bandeira.form-bandeira', ['codigo' => strtoupper($request->input('pais'))]);
});


// Requisição PayPal

Route::prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/', [PayPalController::class, 'createTransaction'])->name('create');
    Route::get('/process', [PayPalController::class, 'processTransaction'])->name('process');
    Route::get('/success', [PayPalController::class, 'successTransaction'])->name('success');
    Route::get('/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancel');
    Route::get('/finish', [PayPalController::class, 'finishTransaction'])->name('finish');
});


require __DIR__.'/auth.php';
