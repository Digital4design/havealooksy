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

Route::get('/', 'HomeController@index')->name('home');

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/get-products/{id}', 'HomeController@getProducts');
Route::get('/get-products/product-details/{id}', 'HomeController@getProductDetails');
Route::get('/get-products/product-availability/{id}', 'HomeController@getProductAvailability');
Route::post('/get-products/apply-filters', 'HomeController@applyFilters');
Route::get('/cart', 'HomeController@viewCart')->middleware('auth');
Route::post('/add-to-cart', 'HomeController@addToCart');
Route::post('/remove-from-cart', 'HomeController@removeFromCart')->middleware('auth');
Route::get('/checkout', 'HomeController@checkoutPage')->middleware('auth');
Route::get('/messages', 'HomeController@messagesView')->middleware('auth');
Route::get('/messages/chat/{id}', 'HomeController@messagesChatView')->middleware('auth');
Route::post('/search', 'HomeController@searchWebsite');

/* Stripe Payment */
Route::get('/checkout', ['as' => 'checkout', 'middleware'=> ['auth'], 'uses' => 'HomeController@stripePaymentView']);
Route::match(['get', 'post'], '/checkout/pay', ['as' => 'stripe_payment', 'middleware'=> ['auth'], 'uses' => 'HomeController@postPaymentWithStripe']);

// Route::group(['prefix' => 'home'], function(){
//     Route::get('/', 'HomeController@index')->name('home');
//     Route::get('/get-products/{id}', 'HomeController@getProducts');
//     Route::get('/get-products/product-details/{id}', 'HomeController@getProductDetails');
//     Route::post('/get-products/apply-filters', 'HomeController@applyFilters');
// });

Route::get('/validate-user', 'HomeController@checkUserRole')->middleware('verified');

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth', 'verified']], function() {
    Route::get('/', 'Admin\DashboardController@index');  
    Route::get('/profile', 'Admin\DashboardController@profile');  
    Route::post('/edit-profile', 'Admin\DashboardController@editProfile');
    Route::get('/change-password', 'Admin\DashboardController@changePassword');  
    Route::post('/save-password', 'Admin\DashboardController@savePassword');
    Route::post('/change-profile-picture', 'Admin\DashboardController@changeProfilePicture');
    Route::get('/remove-profile-picture', 'Admin\DashboardController@removeProfilePicture');
    Route::get('/get-unread-conversations', 'Admin\ChatController@getUnreadConversations');

    /* Users */
    Route::group(['prefix' => 'users', 'middleware' => ['admin', 'auth']], function() {
        Route::get('/', 'Admin\DashboardController@getUsersView');      
        Route::get('/get-users', 'Admin\DashboardController@getUsers');
        Route::get('/view/{id}', 'Admin\DashboardController@viewUser');  
        Route::get('/change-status/{id}/{status}', 'Admin\DashboardController@changeUserStatus');
    }); 

    /* Categories */
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

    /* Listings */
    Route::group(['prefix' => 'listings', 'middleware' => ['admin', 'auth']], function() {
        Route::get('/', ['as' => 'listingsAdmin', 'uses' => 'Admin\ListingController@getListingsView']);
        Route::get('/get-listings', 'Admin\ListingController@getAllListings');
        Route::get('/get-images/{id}', 'Admin\ListingController@getListingImages');
        Route::get('/change-approval/{id}/{status}', 'Admin\ListingController@changeApprovalSetting');
        Route::get('/founder-pick/{id}/{status}', 'Admin\ListingController@changeFounderPickStatus');
        Route::get('/view/{id}', 'Admin\ListingController@viewListing');
        Route::get('/edit-listing/{id}', ['as' => 'editListingAdmin', 'uses' => 'Admin\ListingController@editListingView']);
        Route::get('/remove-listing-image/{id}', 'Admin\ListingController@removeListingImage');
        Route::post('/update-listing', 'Admin\ListingController@updateListing');
        Route::get('/delete-listing/{id}', 'Admin\ListingController@deleteListing');
    });

    /* Bookings */
    Route::group(['prefix' => 'bookings', 'middleware' => ['admin', 'auth']], function(){
        Route::get('/', 'Admin\BookingController@getBookingsView');
        Route::get('/get-bookings', 'Admin\BookingController@getAllBookings');
    });

    /* Chat */
    Route::group(['prefix' => 'chat', 'middleware' => ['admin', 'auth']], function(){
        Route::get('/', 'Admin\ChatController@getAllConversations');
        Route::get('/get-chat/{id}', 'Admin\ChatController@getChat');
        Route::post('/send-message', 'Admin\ChatController@sendMessage');
    });

    /* Notifications */
    Route::get('/markAsRead', function(){
        Auth::user()->unreadNotifications->markAsRead();
    });
    Route::get('/all-notifications', 'Admin\DashboardController@allNotifications'); 
});

Route::group(['prefix' => 'host', 'middleware' => ['host', 'auth', 'verified']], function() {
    Route::get('/', 'Host\DashboardController@index');
    Route::get('/profile', 'Host\DashboardController@profile');  
    Route::post('/edit-profile', 'Host\DashboardController@editProfile');
    Route::get('/change-password', 'Host\DashboardController@changePassword');  
    Route::post('/save-password', 'Host\DashboardController@savePassword');
    Route::post('/change-profile-picture', 'Host\DashboardController@changeProfilePicture');
    Route::get('/remove-profile-picture', 'Host\DashboardController@removeProfilePicture');
    Route::get('/get-unread-conversations', 'Host\ChatController@getUnreadConversations');

    /* Listings */
    Route::group(['prefix' => 'listings', 'middleware' => ['host', 'auth']], function() {
        Route::get('/', ['as' => 'listings', 'uses' => 'Host\DashboardController@getListingsView']);
        Route::get('/get-listings', 'Host\ListingController@getListings');
        Route::get('/get-images/{id}', 'Host\ListingController@getListingImages');
        Route::get('/add-listing', 'Host\ListingController@addListing');
        Route::post('/save-listing', 'Host\ListingController@saveListing');
        Route::get('/view/{id}', 'Host\ListingController@viewListing');
        Route::get('/change-status/{id}/{status}', 'Host\ListingController@changeStatus'); 
        Route::get('/edit-listing/{id}', ['as' => 'editListing', 'uses' => 'Host\ListingController@editListingView']);
        Route::get('/remove-listing-image/{id}', 'Host\ListingController@removeListingImage');
        Route::post('/update-listing', 'Host\ListingController@updateListing'); 
        Route::get('/delete-listing/{id}', 'Host\ListingController@deleteListing'); 
    });

    /* Bookings */
    Route::group(['prefix' => 'bookings', 'middleware' => ['host', 'auth']], function(){
        Route::get('/', 'Host\BookingController@getBookingsView');
        Route::get('/get-bookings', 'Host\BookingController@getAllBookings');
        Route::get('/get-booking-data/{id}', 'Host\BookingController@getBookingData');
        Route::get('/get-bookings-table', 'Host\BookingController@getBookingsTable');
        Route::get('/change-confirmation/{id}/{data}', 'Host\BookingController@changeBookingConfirmation');
    });

    /* Chat */
    Route::group(['prefix' => 'chat', 'middleware' => ['host', 'auth']], function(){
        Route::get('/', 'Host\ChatController@getAllConversations');
        Route::get('/get-chat/{id}', 'Host\ChatController@getChat');
        Route::post('/send-message', 'Host\ChatController@sendMessage');
    });

    /* Notifications */
    Route::get('/markAsRead', function(){
        Auth::user()->unreadNotifications->markAsRead();
    });
    Route::get('/all-notifications', 'Host\DashboardController@allNotifications');    
});

Route::group(['prefix' => 'shopper', 'middleware' => ['auth', 'shopper', 'verified']], function() {
    Route::get('/', 'Shopper\DashboardController@index');
    Route::get('/dashboard', 'Shopper\DashboardController@dashboardView');
    Route::get('/profile', 'Shopper\DashboardController@profile');  
    Route::post('/edit-profile', 'Shopper\DashboardController@editProfile');
    Route::get('/change-password', 'Shopper\DashboardController@changePassword');  
    Route::post('/save-password', 'Shopper\DashboardController@savePassword');
    Route::post('/change-profile-picture', 'Shopper\DashboardController@changeProfilePicture');
    Route::get('/remove-profile-picture', 'Shopper\DashboardController@removeProfilePicture');
    Route::get('/get-unread-conversations', 'Shopper\ChatController@getUnreadConversations');

    /* Bookings */
    Route::group(['prefix' => 'bookings', 'middleware' => ['shopper', 'auth']], function(){
        Route::get('/', 'Shopper\BookingController@getBookingsView');
        Route::get('/get-bookings', 'Shopper\BookingController@getAllBookings');
        Route::get('/get-booking-data/{id}', 'Shopper\BookingController@getBookingData');
    });

    /* Chat */
    Route::group(['prefix' => 'chat', 'middleware' => ['shopper', 'auth']], function(){
        Route::get('/', 'Shopper\ChatController@getAllConversations');
        Route::get('/get-chat/{id}', 'Shopper\ChatController@getChat');
        Route::post('/send-message', 'Shopper\ChatController@sendMessage');
    });

    /* Notifications */
    Route::get('/markAsRead', function(){
        Auth::user()->unreadNotifications->markAsRead();
    });
    Route::get('/all-notifications', 'Shopper\DashboardController@allNotifications');   
});

/*
Route::get('facebook', function () {
    return view('facebook');
});
*/
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
