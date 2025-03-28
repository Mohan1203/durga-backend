<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\application_categories;
use App\Http\Controllers\user\application_product;
use App\Http\Controllers\user\events_and_news;
use App\Http\Controllers\user\group_of_companies;
use App\Http\Controllers\user\user_contact;
use App\Http\Controllers\user\setting;

// Apply CORS middleware to all routes

Route::post('/application_categories', [application_categories::class, 'get_all_categories']);

Route::post('/application_product', [application_product::class,'get_all_application_product']);

Route::post('/news_and_events',[events_and_news::class,'get_all_events']);

Route::post("/group_of_companies",[group_of_companies::class,'get_all_timeline']);

Route::post("/send_contact_email",[user_contact::class,'sendContactEmail']);

Route::post("/setting",[setting::class,'index']);

Route::post('/product_portfolio', [ApiController::class, 'getProductPortfolio']);

Route::post('/get_product_portfolio_details', [ApiController::class, 'getProductPortfolioDetail']);


    Route::post('/application_categories', [application_categories::class, 'get_all_categories']);
    Route::post('/application_product', [application_product::class,'get_all_application_product']);
    Route::post('/related_products', [application_product::class,'get_related_products']);
    Route::post('/debug_product', [application_product::class,'debug_product']);
    Route::post('/news_and_events',[events_and_news::class,'get_all_events']);
    Route::post("/group_of_companies",[group_of_companies::class,'get_all_timeline']);
    Route::post("/send_contact_email",[user_contact::class,'sendContactEmail']);
    Route::post("/setting",[setting::class,'index']);
    Route::post('/product_portfolio', [ApiController::class, 'getProductPortfolio']);
    Route::post('/get_product_portfolio_details', [ApiController::class, 'getProductPortfolioDetail']);
    Route::post('/product_portfolio/{slug}', [ApiController::class, 'getProductPortfolioDetail']);