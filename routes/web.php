<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $http = new GuzzleHttp\Client;
    $response = $http->request('get', 'localhost/carmart/public/api/users/getinfo', [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '."eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNDMyNWRjNTczYzA5ZTc0MWQ2Y2I5YWE0ZWEyYWUwODQ0ZTUwYjJkNWJkNzdjNmQ1MWVjODc5OTFkYWE2NmYyOGMzNWI1N2IzOGQ0YTk5YmUiLCJpYXQiOjE2MTE1MDI0MzYsIm5iZiI6MTYxMTUwMjQzNiwiZXhwIjoxNjEyNzk4NDM1LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.T0H1PSIZACD6v6ovdD4pZ1YF-vvSZXaTMVzl7P_EAeXGnonJ6jbyHvN0d2WeIKAojSAx_BqoNOklqLYy1lYaApB9ELf3BvJ-lqzFYmUZlK4BNrFFSRxLmbV802RG4fPR0G7lTqxcxvThwq48o5W9oiqiM7oJl8QNFRbpoZlIxW7_FD3hWdv_twUSrFUXM1PyMcyxVvX0A2DNJxV2DbxUcy4bvQbHHTEHFgdbTYvzspMQCRIXhBymL5DX8mdftYmMxOZBYTbNlZwKqTZkTe2_oS0TUs0JupEI5dP5XGyrkNdJVqzUhz4uxNqAiRP1cqgikNoFlMtKnxeM6yP0kvDXxyIgDtKDfPeJNfzzFZ9f7IJ5GnDKJO0_hbqoIcKMwVm4uhpyOJehKsuAOoR2U2zkuCWuSuJ9b43PugZhTEKza-7jLBs1qF2w2yjHCm9SFizCPPvyXzxMy71hsBx8Wq2jqyY4AjdlzmcX3F1o3ciEYTVzxn3kQp5BGdtd-kCq07-Rot_NkNq7eoZgKKe1CyldrU6KfcNkMNBl9IxiZpHONedptvQY5-KiEZTLNqLR3rbolCrY9Ihk9FeZCVq4E6Njy_IvYkDG_28d29KugeDLlyt69SUmLb0AAJPfzfTn1a9yk1pcWsytO5KXPcGXJ_VeUFUvXIkwC80JO40rM-F66c4",            
        ],
        
    ]);
    return json_decode((string) $response->getBody(), true);
    return view('welcome');
});

Route::get('/test', function () {
 return view("test");
});

Route::resource('/users',"App\Http\Controllers\Users\UserController");
Route::resource('/notifications',"App\Http\Controllers\Notifications\NotificationController");
Route::resource('/rates',"App\Http\Controllers\Rates\RateController");
Route::resource('/reports',"App\Http\Controllers\Reports\ReportController");
Route::resource('/requests',"App\Http\Controllers\Requests\RequestController");
Route::resource('/services',"App\Http\Controllers\Services\ServiceController");
Route::resource('/settings',"App\Http\Controllers\Settings\SettingController");
Route::resource('/notifications',"App\Http\Controllers\NotificationController");
Route::resource('/branches',"App\Http\Controllers\BranchController");
Route::resource('/contactus',"App\Http\Controllers\ContactUs\ContactUsController");

Route::get('/settings',"App\Http\Controllers\Settings\SettingController@appsettings")->name("appsettings");

Route::post('/settings',"App\Http\Controllers\Settings\SettingController@appsettingsstore")->name("appsettings.store");

Route::get('/cars',"App\Http\Controllers\Settings\SettingController@CarsIndex")->name("cars.index");
Route::post('/cars',"App\Http\Controllers\Settings\SettingController@CarsStore")->name("cars.store");
Route::put('/cars/{id}',"App\Http\Controllers\Settings\SettingController@CarsUpdate")->name("cars.update");
Route::delete('/cars/{id}',"App\Http\Controllers\Settings\SettingController@CarsDestroy")->name("cars.destroy");
Route::post('/cars_search',"App\Http\Controllers\Settings\SettingController@CarsSearch")->name("cars.search");

//categories route
Route::get('/categories',"App\Http\Controllers\Settings\SettingController@CategoriesIndex")->name("categories.index");
Route::post('/categories',"App\Http\Controllers\Settings\SettingController@CategoriesStore")->name("categories.store");
Route::put('/categories/{id}',"App\Http\Controllers\Settings\SettingController@CategoriesUpdate")->name("categories.update");
Route::delete('/categories/{id}',"App\Http\Controllers\Settings\SettingController@CategoriesDestroy")->name("categories.destroy");
Route::post('/categories_search',"App\Http\Controllers\Settings\SettingController@CategoriesSearch")->name("categories.search");




Route::post('/users_search',"App\Http\Controllers\Users\UserController@Search")->name("users.search");
Route::post('/notifications_search',"App\Http\Controllers\NotificationController@Search")->name("notifications.search");
Route::post('/services_search',"App\Http\Controllers\Services\ServiceController@Search")->name("services.search");
Route::post('/requests_search',"App\Http\Controllers\Requests\RequestController@Search")->name("requests.search");
Route::post('/branches_search',"App\Http\Controllers\BranchController@Search")->name("branches.search");

Route::get('/getphotos/{folder_name}', "App\Http\Controllers\Settings\SettingController@GetPhotos")->name('photos.index');
Route::post('/storephoto', "App\Http\Controllers\Settings\SettingController@StorePhoto")->name('photos.store');
Route::delete('deletephotos', "App\Http\Controllers\Settings\SettingController@DestroyPhoto")->name('photos.destroy');
Route::delete('specifications/{id}', "App\Http\Controllers\HomeController@DeleteSpecification")->name('specifications.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/edit_profile', [App\Http\Controllers\HomeController::class, 'EditProfile'])->name('edit_profile');

Route::get("/check_user_existance/{account_name}","App\Http\Controllers\Users\UserController@check_user_existance")->name("check_user_existance");
Route::get('/services/{id}/users',"App\Http\Controllers\Services\ServiceController@Users")->name("services.users.index");
Route::get('/users/{id}/services',"App\Http\Controllers\Users\UserController@GetServices")->name("users.services.index");

Route::put('/specifications/{id}',"App\Http\Controllers\HomeController@UpdateSpecification")->name("specifications.update");

Route::get('/specifications',"App\Http\Controllers\HomeController@GetSpecifications")->name("specifications.index");
Route::post('/specifications',"App\Http\Controllers\HomeController@StoreSpecification")->name("specifications.store");
Route::get("logout","App\Http\Controllers\Auth\LoginController@logout")->name("logout");
Route::post('/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('save-token');
Route::get('/send-notification', [App\Http\Controllers\HomeController::class, 'sendNotification'])->name('send.notification');
