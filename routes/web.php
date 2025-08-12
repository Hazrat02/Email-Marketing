<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [ContactController::class, 'home']);


Route::get('/admin', function () {
    return view('smtp');
});
Route::get('/start', function () {

    Artisan::call('queue:work');
     return back()->with('success', 'Worker started!');
});


Route::post('/contact', [ContactController::class, 'sendBulkMail'])->name('contact.send');
Route::post('/smtp/store', [ContactController::class, 'store'])->name('smtp.store');
