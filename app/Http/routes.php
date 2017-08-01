<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {

    /** Auth */
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
    Route::auth();

    /** Order */
    Route::get('packages', 'OrderController@showPackages');
    Route::post('packages', 'OrderController@postPackages');
    Route::get('zodiac', 'OrderController@showZodiacSigns');
    Route::post('zodiac', 'OrderController@postZodiacSigns');
    Route::get('dedication', 'OrderController@showDedication');
    Route::post('dedication', 'OrderController@postDedication');
    Route::get('magnitude', 'OrderController@showMagnitude');
    Route::post('magnitude', 'OrderController@postMagnitude');
    Route::get('vip', 'OrderController@showVip');
    Route::post('vip', 'OrderController@postVip');
    Route::get('order-overview/{customer_id?}', 'OrderController@showOverview');
    Route::get('thank-you', 'OrderController@showThankYou');
    Route::get('order-history', 'OrderController@showOrderHistory');
    Route::get('order-detail/{order_id}', 'OrderController@showOrderDetail');
    Route::get('download-pdf/{order_id}', 'OrderController@downloadPdf');
    Route::get('view-pdf/{order_id}', 'OrderController@viewPdf');

    /** Billing */
    Route::post('pay', 'BillingController@payFromToken');
    Route::post('charge', 'BillingController@chargeExistingCustomer');
    Route::get('choose-payment-method', 'BillingController@showChoosePaymentMethod');
    Route::get('subscriptions', 'BillingController@showSubscriptions');
    Route::get('cancel-subscription/{customer_id}', 'BillingController@cancelSubscription');
    Route::post('stripe-web-hook', 'BillingController@stripeWebHook');

    /** Static / Misc */
    Route::get('terms', 'OrderController@showTerms');

    /** Index */
    Route::get('/', 'OrderController@showIndex');
});