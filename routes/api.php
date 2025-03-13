<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\application_categories;
use App\Http\Controllers\user\application_product;


Route::get('/application_categories', [application_categories::class, 'get_all_categories']);

Route::get('/application_product', [application_product::class,'get_all_application_product']);