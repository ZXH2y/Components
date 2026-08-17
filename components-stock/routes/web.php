<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/scroll-expand', function(){
    return view('scroll-expand');
});