<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return phpinfo();
})->name('login');
