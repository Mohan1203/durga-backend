<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth_controller;
use App\Http\Controllers\Dashboard_controller;
use App\Http\Controllers\Application_products_contoller;
use App\Http\Controllers\Application_categories_controller;
use App\Http\Controllers\Product_portfolios_categories_contoller;
use App\Http\Controllers\Group_of_companies_contoller;
use App\Http\Controllers\EventsAndNewsController;
use App\Http\Controllers\ApplicationProductController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProductPortfolioController;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\SettingContoller;

Route::get('/login', [auth_controller::class, 'show_login'])->name('login');
Route::post('/login', [auth_controller::class, 'handle_login'])->name('handle.login');
Route::post('/logout', [auth_controller::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->get('/', [Dashboard_controller::class,'show_dashboard'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get("/",[Application_categories_controller::class,"show_application_categories"])->name('handle.application-categories');
    Route::post("/",[Application_categories_controller::class,"add_application_categories"]);
    Route::get("/edit_category/{id}",[Application_categories_controller::class,"show_edit_application_categories"]);
    Route::post("/edit_category/{id}",[Application_categories_controller::class,"edit_application_category"])->name('handle.edit-categories');
    Route::post("/delele_category/{id}",[Application_categories_controller::class,"delete_application_category"])->name('handle.delete-categories');
    


    Route::resource('application-products', ApplicationProductController::class);
    
    Route::delete("/delete-feature/{id}",[ProductPortfolioController::class,"deleteFeature"])->name('feature.delete');
    Route::delete("/delete-grade/{id}",[ProductPortfolioController::class,"deleteGrade"])->name('grade.delete'); 
    Route::delete("/delete-industry/{id}",[ProductPortfolioController::class,"deleteIndustry"])->name('industry.delete');
    Route::delete("/delete-feature-section/{id}",[ProductPortfolioController::class,"deleteFeatureSection"])->name('feature-section.delete');
    Route::delete("/delete-key-feature/{id}",[ProductPortfolioController::class,"deleteKeyFeature"])->name('handle.delete-key-feature');
    Route::resource('product-portfolio', ProductPortfolioController::class);
   

    Route::get("/product-portfolios-categories",[Product_portfolios_categories_contoller::class,"show_product_portfolios_categories"]);

    Route::get("/group-of-companies",[Group_of_companies_contoller::class,"show_group_of_companies"]); 
    Route::post("/add-timeline",[Group_of_companies_contoller::class,'handle_add_year'])->name('handle.add-year');
    Route::get("/show-group-of-company",[Group_of_companies_contoller::class,'handle_show_data'])->name("handle.show-grp-comp");
    Route::get("/show-edit-group-of-company/{id}",[Group_of_companies_contoller::class,'handle_show_edit'])->name("handle.show-edit-grp-comp");
    Route::post("/edit-group-of-company/{id}",[Group_of_companies_contoller::class,'handle_edit_data'])->name("handle.edit-grp-cmp");
    Route::delete('/delete-group-of-comp/{id}',[Group_of_companies_contoller::class,'delete_timeline'])->name('handle.delete_timeline');
    
    Route::resource("/events-and-news",EventsAndNewsController::class);
    Route::resource('/settings',SettingContoller::class);
    
    Route::get('/refresh-csrf', function() {
        return csrf_token();
    })->name('refresh-csrf');
});                                                             

// Application products routes
// Route::middleware(['auth'])->get('/add-application-products',[Application_products_contoller::class,'add_products'])->name('handle.add-application-products');
// Route::middleware(['auth'])->get('/edit-application-products/{id}',[Application_products_contoller::class,'edit_products'])->name('handle.edit-application-products');
// Route::middleware(['auth'])->post('/add-application-products',[Application_products_contoller::class,'handle_add_product'])->name('handle.add-application-products');
// Route::middleware(['auth'])->post("/edit-application-product/{id}",[Application_products_contoller::class,'handle_edit_product'])->name('handle.edit-application-products');
// Route::middleware(['auth'])->post('/edit-application-product/{id}',[Application_products_contoller::class,'handle_delete_product'])->name('handle.delete-application-products');


// Route::middleware(['auth'])->get("/product-portfolios-categories",[Product_portfolios_categories_contoller::class,"show_product_portfolios_categories"]);

// Route::middleware(['auth'])->get("/group-of-companies",[Group_of_companies_contoller::class,"show_group_of_companies"]);
// Route::middleware(['auth'])->post("/add-timeline",[Group_of_companies_contoller::class,"handle_add_year"])->name('handle.add-year');

// Route::middleware(['auth'])->get("/events-and-news",[Events_and_news_contoller::class,"show_events_and_news"]);



Route::get('clear', static function () {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    return redirect()->back();
});

Route::get('storage-link', static function () {
    try {
        Artisan::call('storage:link');
        echo "storage link created";
    } catch (Exception) {
        echo "Storage Link already exists";
    }
    return redirect()->back();
});


Route::get('migrate', static function () {
    Artisan::call('migrate');
//    return redirect()->back();
    echo "Done";
    return false;
});

Route::get('admin-seeders', static function () {
    Artisan::call('db:seed --class=AdminSeeder');
    echo "Done";
    return false;
});

Route::get('migrate-rollback', static function () {
    Artisan::call('migrate:rollback');
    echo "Done";
    return false;
});