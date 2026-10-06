<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/scroll-expand', function(){
    return view('scroll-expand');
});

Route::get('/prallax', function(){
    return view('parallax');
});


Route::get('/radial', function(){
    return view('radial-orbital');
});