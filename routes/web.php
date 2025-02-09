<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('welcome', 'welcome');
Route::view('about', 'about');
Route::view('other', 'other');
