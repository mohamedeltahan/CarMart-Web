<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'auth:api'], function () {

    Route::resource('/carts',"App\Http\Controllers\Carts\CartsController");

    Route::delete('/requests/{id}',"App\Http\Controllers\Requests\RequestController@destroy");
    Route::resource('/rates',"App\Http\Controllers\Rates\RateController");
    Route::get('requests',"App\Http\Controllers\Requests\RequestController@index");
    Route::get('/logout',"App\Http\Controllers\Auth\LoginController@logout");
    Route::post('/requests',"App\Http\Controllers\Requests\RequestController@store");

    Route::post('/wishlist',"App\Http\Controllers\Users\UserController@AddItemToWishlist");

    Route::get('/wishlist',"App\Http\Controllers\Users\UserController@GetWishlist");
    Route::delete('/wishlist',"App\Http\Controllers\Users\UserController@EmptyWishlist");
    
    Route::delete('/wishlist/{id}',"App\Http\Controllers\Users\UserController@DeleteItemFromWishlist");
        
    Route::get("users/getinfo","App\Http\Controllers\Users\UserController@GetUserInfo");
    Route::get('/notifications',"App\Http\Controllers\Notifications\NotificationController@index");
    Route::get('/GetUserGarage',"App\Http\Controllers\Users\UserController@GetUserGarage");
    Route::post('/AttachToGarage',"App\Http\Controllers\Users\UserController@AttachToGarage");
    Route::get('/contactus',"App\Http\Controllers\ContactUs\ContactUsController@index");
    Route::post('/contactus',"App\Http\Controllers\ContactUs\ContactUsController@store");
    Route::post('/chatus',"App\Http\Controllers\ContactUs\ContactUsController@ChatUsStore");
    Route::post('/users/{id}',"App\Http\Controllers\Users\UserController@update");
    Route::get('/GetUserRequests',"App\Http\Controllers\Users\UserController@GetUserRequests");
    Route::get('/GetRequest/{id}',"App\Http\Controllers\Requests\RequestController@GetRequest");
    Route::get('/logged_homepage',"App\Http\Controllers\Services\ServiceController@HomepageServices");

    
    

});
Route::get('/GetWasherBranchService/{id}',"App\Http\Controllers\Services\ServiceController@GetWasherBranchService");

Route::get('/GetBranchVendor',"App\Http\Controllers\Services\ServiceController@GetBranchVendor");

Route::post('services/filter',"App\Http\Controllers\Services\ServiceController@Filter");

Route::post('/CreateResetPasswordCode',"App\Http\Controllers\Auth\ForgotPasswordController@CreateResetPasswordCode")->name("api.create_code");
Route::post('/ResetPassword',"App\Http\Controllers\Auth\ResetPasswordController@ResetPassword")->name("api.ResetPassword");

Route::post('/register',"App\Http\Controllers\Auth\RegisterController@Register")->name("api.register");

Route::post('category/services',"App\Http\Controllers\Services\ServiceController@GetCategoryServices");

Route::post('services/nearestservices',"App\Http\Controllers\Services\ServiceController@NearestServices");
Route::get('/homepage',"App\Http\Controllers\Services\ServiceController@HomepageServices");



Route::get('/services/{id}',"App\Http\Controllers\Services\ServiceController@show");

Route::get('/services/{id}',"App\Http\Controllers\Services\ServiceController@show");
Route::get('/ServiceBranches/{id}',"App\Http\Controllers\Services\ServiceController@GetBranches");
Route::get('/VendorBranches/{id}',"App\Http\Controllers\Users\UserController@GetBranches");


//users categories
Route::get('/categories',"App\Http\Controllers\Settings\SettingController@CategoriesIndex");
Route::get('/subcategories',"App\Http\Controllers\Settings\SettingController@SubCategoriesIndex");


Route::get('/GetSubCategoryServices',"App\Http\Controllers\Services\ServiceController@GetSubCategoryServices");



Route::get("vendors/specifications","App\Http\Controllers\Users\UserController@GroupVendorBySpecfications");
Route::post('/vendors/services',"App\Http\Controllers\Users\UserController@GetVendorServices");

Route::get('/services',"App\Http\Controllers\Services\ServiceController@index");

Route::post('/login',"App\Http\Controllers\Users\UserController@ApiLogin");

Route::post('/users_search',"App\Http\Controllers\Users\UserController@Search")->name("users.search");
Route::get("/check_user_existance/{account_name}","App\Http\Controllers\Users\UserController@check_user_existance")->name("check_user_existance");



Route::post('/categories_search',"App\Http\Controllers\Settings\SettingController@CategoriesSearch")->name("categories.search");

Route::get('/cars',"App\Http\Controllers\Settings\SettingController@CarsIndex")->name("cars.index");
Route::post('/cars_search',"App\Http\Controllers\Settings\SettingController@CarsSearch")->name("cars.search");

Route::get('/GetWinshes',"App\Http\Controllers\Users\UserController@GetWinshes");
Route::get('/GetWashers',"App\Http\Controllers\Users\UserController@GetWashers");
Route::get('/GetMechanics',"App\Http\Controllers\Users\UserController@GetMechanics");
Route::get('/GetSuppliers',"App\Http\Controllers\Users\UserController@GetSuppliers");


Route::get('/winshes/{id}',"App\Http\Controllers\Users\UserController@GetWinsh");
Route::get('/washers/{id}',"App\Http\Controllers\Users\UserController@GetWasher");
Route::get('/mechanics/{id}',"App\Http\Controllers\Users\UserController@GetMechanic");
Route::get('/suppliers/{id}',"App\Http\Controllers\Users\UserController@GetSupplier");

Route::get('/NewArrivalsServices',"App\Http\Controllers\Services\ServiceController@NewArrivalsServices");
Route::get('/GetSparePartsForCar/{id}',"App\Http\Controllers\Services\ServiceController@GetSparePartsForCar");
Route::get('/GetMaintenanceForCar/{id}',"App\Http\Controllers\Services\ServiceController@GetMaintenanceForCar");


Route::get('/BestSellerServices',"App\Http\Controllers\Services\ServiceController@BestSellerServices");

Route::get('/GetCarBrands',"App\Http\Controllers\Settings\SettingController@GetCarBrands");
Route::get('/GetCarId/{brand}/{model}/{year}',"App\Http\Controllers\Settings\SettingController@GetCarId");

Route::get('/GetCarYears/{brand}/{model}',"App\Http\Controllers\Settings\SettingController@GetCarYears");

Route::get('/GetCarModels/{model}',"App\Http\Controllers\Settings\SettingController@GetCarModels");

Route::get('/specifications',"App\Http\Controllers\HomeController@GetSpecifications")->name("specifications.index");

Route::get('/Brands',"App\Http\Controllers\Users\UserController@GetBrands");

