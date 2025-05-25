<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/issues', function () {
    return view('issues')->layout('app');
});
