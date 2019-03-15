<?php

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
	//return view('welcome');
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/usersList', 'HomeController@usersList')->name('usersList');
Route::get('/validate-user', 'HomeController@checkUserRole');

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function() {
    Route::get('/', 'Admin\DashboardController@index');  
    Route::get('/profile', 'Admin\DashboardController@profile');  
    Route::post('/edit-profile', 'Admin\DashboardController@editProfile');
    Route::get('/change-password', 'Admin\DashboardController@changePassword');  
    Route::post('/save-password', 'Admin\DashboardController@savePassword');  
    Route::get('/users', 'Admin\DashboardController@getUsersView');  
    Route::get('/get-users', 'Admin\DashboardController@getUsers');  

    Route::group(['prefix' => 'categories', 'middleware' => ['admin', 'auth']], function() {
        Route::get('/', 'Admin\DashboardController@getCategoriesView');
        Route::get('/get-categories', 'Admin\DashboardController@getCategories');  
        Route::post('/add-category', 'Admin\DashboardController@addCategory');
        Route::get('/change-status/{id}/{status}', 'Admin\DashboardController@changeStatus');
        Route::get('/delete-category/{id}', 'Admin\DashboardController@deleteCategory');
        Route::get('/get-category-data/{id}', 'Admin\DashboardController@getCategoryData');
        Route::post('/edit-category', 'Admin\DashboardController@editCategory');
    }); 
});

Route::group(['prefix' => 'seller', 'middleware' => ['seller', 'auth']], function() {
    Route::get('/', 'Seller\DashboardController@index');

    Route::group(['prefix' => 'listings', 'middleware' => ['seller', 'auth']], function() {
        Route::get('/', ['as' => 'listings', 'uses' => 'Seller\DashboardController@getListingsView']);
        Route::get('/get-listings', 'Seller\ListingController@getListings');
        Route::get('/add-listing', 'Seller\ListingController@addListing');
        Route::post('/save-listing', 'Seller\ListingController@saveListing'); 
    });    
});

/*
Route::get('facebook', function () {
    return view('facebook');
});
*/
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
