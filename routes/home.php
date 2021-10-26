<?php 

use Illuminate\Support\Facades\Route;
    Route::get('/','App\Http\Controllers\UserCtr@index')->name('home');
    Route::get('/login','App\Http\Controllers\UserCtr@login')->name('login');
    Route::post('/authlogin','App\Http\Controllers\UserCtr@authlogin')->name('authlogin');
    Route::post('/authres','App\Http\Controllers\UserCtr@authres')->name('authres');
    Route::get('/myaccount','App\Http\Controllers\UserCtr@myaccount')->name('myaccount');
    Route::get('/upInfo','App\Http\Controllers\UserCtr@upInfo')->name('upInfo');
    
?>