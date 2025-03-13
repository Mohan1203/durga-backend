<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth_controller;
use App\Http\Controllers\Dashboard_controller;
use App\Http\Controllers\Application_products_contoller;
use App\Http\Controllers\Application_categories_controller;
use App\Http\Controllers\Product_portfolios_categories_contoller;
use App\Http\Controllers\Group_of_companies_contoller;
use App\Http\Controllers\Events_and_news_contoller;

Route::get('/login', [auth_controller::class, 'show_login'])->name('login');
Route::post('/login', [auth_controller::class, 'handle_login'])->name('handle.login');

// Route::middleware(['auth'])->get('/', [Dashboard_controller::class,'show_dashboard'])->name('home');

// Application categories routes
Route::middleware(['auth'])->get("/",[Application_categories_controller::class,"show_application_categories"])->name('handle.application-categories');
Route::middleware(['auth'])->post("/",[Application_categories_controller::class,"add_application_categories"]);

// Application products routes
Route::middleware(['auth'])->get('/add-application-products',[Application_products_contoller::class,'add_products'])->name('handle.add-application-products');
Route::middleware(['auth'])->get('/edit-application-products/{id}',[Application_products_contoller::class,'edit_products'])->name('handle.edit-application-products');
Route::middleware(['auth'])->post('/add-application-products',[Application_products_contoller::class,'handle_add_product'])->name('handle.add-application-products');
Route::middleware(['auth'])->post("/edit-application-product/{id}",[Application_products_contoller::class,'handle_edit_product'])->name('handle.edit-application-products');
Route::middleware(['auth'])->post('/edit-application-product/{id}',[Application_products_contoller::class,'handle_delete_product'])->name('handle.delete-application-products');


Route::middleware(['auth'])->get("/product-portfolios-categories",[Product_portfolios_categories_contoller::class,"show_product_portfolios_categories"]);

Route::middleware(['auth'])->get("/group-of-companies",[Group_of_companies_contoller::class,"show_group_of_companies"]);
Route::middleware(['auth'])->post("/add-timeline",[Group_of_companies_contoller::class,"handle_add_year"])->name('handle.add-year');

Route::middleware(['auth'])->get("/events-and-news",[Events_and_news_contoller::class,"show_events_and_news"]);