<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.pages.login');
});

Route::get('/register', function () {
    return view('public.pages.register');
});

Route::get('/forgot-password', function () {
    return view('public.pages.forgot-password');
});

Route::get('/dashboard', function () {
    return view('private.pages.dashboard');
});
