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

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', 'HomeController@index');

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/validate-user', 'HomeController@checkUserRole')->middleware('verified');

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth', 'verified']], function() {
    Route::get('/', 'Admin\DashboardController@index');  
    Route::get('/profile', 'Admin\DashboardController@profile');  
    Route::post('/edit-profile', 'Admin\DashboardController@editProfile');
    Route::get('/change-password', 'Admin\DashboardController@changePassword');  
    Route::post('/save-password', 'Admin\DashboardController@savePassword');
    Route::post('/change-profile-picture', 'Admin\DashboardController@changeProfilePicture');
    Route::get('/remove-profile-picture', 'Admin\DashboardController@removeProfilePicture');

    Route::group(['prefix' => 'users', 'middleware' => ['admin', 'auth']], function() {
        Route::get('/', 'Admin\DashboardController@getUsersView');    
        Route::get('/get-users', 'Admin\DashboardController@getUsers');
        Route::get('/change-status/{id}/{status}', 'Admin\DashboardController@changeUserStatus');
    }); 

    Route::group(['prefix' => 'categories', 'middleware' => ['admin', 'auth']], function() {
        Route::get('/', 'Admin\DashboardController@getCategoriesView');
        Route::get('/get-categories', 'Admin\DashboardController@getCategories');  
        Route::post('/add-category', 'Admin\DashboardController@addCategory');
        Route::get('/change-status/{id}/{status}', 'Admin\DashboardController@changeStatus');
        Route::get('/delete-category/{id}', 'Admin\DashboardController@deleteCategory');
        Route::get('/get-category-data/{id}', 'Admin\DashboardController@getCategoryData');
        Route::post('/edit-category', 'Admin\DashboardController@editCategory');
        Route::get('/remove-image/{id}', 'Admin\DashboardController@removeCategoryImage');
    }); 
});

Route::group(['prefix' => 'seller', 'middleware' => ['seller', 'auth', 'verified']], function() {
    Route::get('/', 'Seller\DashboardController@index');
    Route::get('/profile', 'Seller\DashboardController@profile');  
    Route::post('/edit-profile', 'Seller\DashboardController@editProfile');
    Route::get('/change-password', 'Seller\DashboardController@changePassword');  
    Route::post('/save-password', 'Seller\DashboardController@savePassword');
    Route::post('/change-profile-picture', 'Seller\DashboardController@changeProfilePicture');
    Route::get('/remove-profile-picture', 'Seller\DashboardController@removeProfilePicture');

    Route::group(['prefix' => 'listings', 'middleware' => ['seller', 'auth']], function() {
        Route::get('/', ['as' => 'listings', 'uses' => 'Seller\DashboardController@getListingsView']);
        Route::get('/get-listings', 'Seller\ListingController@getListings');
        Route::get('/add-listing', 'Seller\ListingController@addListing');
        Route::post('/save-listing', 'Seller\ListingController@saveListing');
        Route::get('/change-status/{id}/{status}', 'Seller\ListingController@changeStatus');
        Route::get('/change-favorite-status/{id}/{status}', 'Seller\ListingController@changeFavoriteStatus'); 
        Route::get('/edit-listing/{id}', ['as' => 'editListing', 'uses' => 'Seller\ListingController@editListingView']);
        Route::post('/update-listing', 'Seller\ListingController@updateListing'); 
        Route::get('/delete-listing/{id}', 'Seller\ListingController@deleteListing'); 
    });    
});

/*
Route::get('facebook', function () {
    return view('facebook');
});
*/
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
