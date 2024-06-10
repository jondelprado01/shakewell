<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function(){

    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
    Route::post('/register', 'register');

    Route::middleware('auth')->group(function(){
        Route::get('/voucher-list', 'listVoucher');
        Route::post('/voucher-add', 'addVoucher');
        Route::delete('/voucher-delete/{id}', 'deleteVoucher');
    });
 
});

Route::get('/token', function(){
    return csrf_token();
});