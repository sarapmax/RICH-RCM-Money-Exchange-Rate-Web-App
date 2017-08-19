<?php

Route::group([
    'namespace' => 'Page',
    'as' => 'page.'
], function() {
    Route::get('/', 'HomeController@showHomePage')->name('home');
    Route::get('currency', 'HomeController@getCurrencyWithBanknotes')->name('currency');
    Route::get('currency-last-updated', 'Homecontroller@getCurrencyLastUpdated');
});

// Authentication Routes.
Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth' ,
    'as' => 'auth.',
], function() {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('password/forgot', 'ForgotPasswordController@showLinkRequestForm')->name('forgot-password');
    Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('reset-password');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('save-reset-password');;
});

// Admin Routes.
Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.'
], function() {
    Route::post('currency/add', 'CurrencyController@addCurrency');
    Route::get('currency/{currency_id}', 'CurrencyController@getCurrencyById');
    Route::post('currency/{currency_id}/update', 'CurrencyController@updateCurrency');
    Route::post('currency/{currency_id}/delete', 'CurrencyController@deleteCurrency');

    Route::post('banknote/{banknote_id}/delete', 'BanknoteController@deleteBanknote');

    Route::get('countries', 'CountryController@getAllCountries');
});
