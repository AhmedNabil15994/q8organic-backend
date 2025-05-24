<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'checkout'], function () {

    Route::get('/', 'FrontEnd\CheckoutController@index')
        ->name('frontend.checkout.index')
        ->middleware(['empty.cart']);

    Route::get('/get-address', 'FrontEnd\CheckoutController@loadUserAddress')
        ->name('frontend.checkout.load.addresses')
        ->middleware(['empty.cart','auth']);

//  	Route::get('/contact-info' ,'FrontEnd\CheckoutController@getContactInfo')
//  	->name('frontend.checkout.contact_info.index')
//    ->middleware(['empty.cart']);

//  	Route::get('/payment-methods' ,'FrontEnd\CheckoutController@getPaymentMethods')
//  	->name('frontend.checkout.payment_methods.index')
//    ->middleware(['empty.cart']);


    Route::post('save-checkout-information', 'FrontEnd\CheckoutController@saveCheckoutInformation')
        ->name('frontend.checkout.save_checkout_information')
        ->middleware(['empty.cart']);

    Route::post('get-state-delivery-price', 'FrontEnd\CheckoutController@getStateDeliveryPrice')
        ->name('frontend.checkout.get_state_delivery_price')
        ->middleware(['empty.cart']);


    Route::post('/', 'FrontEnd\CheckoutController@createOrder')
        ->name('frontend.checkout.create_order')
        ->middleware(['empty.cart', 'empty.address']);
});
