<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/tutorial', function () {
    return view('pages.tutorial');
})->name('tutorial');

Route::get('/materi', function () {
    return view('pages.materi');
})->name('materi');

Route::get('/simulasi', function () {
    return view('pages.simulasi');
})->name('simulasi');

Route::get('/quiz', function () {
    return view('pages.quiz');
})->name('quiz');
