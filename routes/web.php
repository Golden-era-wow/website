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

Route::get('/', 'WelcomeController@index');
Route::get('news/{news}', 'NewsController@show')->name('news.show');
Route::get('armory', 'ArmoryController@index')->name('armory.index');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('settings', 'SettingsController@index')->name('settings.index');
    
    Route::get('shop', 'ShopController@index')->name('shop.index');
    Route::get('shopping-cart', 'ShoppingCartController@show')->name('shopping-cart.index');
    Route::post('carts', 'CartController@store')->name('carts.store');
    
    Route::post('carts/{cart}/product/{product}', 'CartProductController@store')->name('carts.product.store');
    Route::delete('carts/{cart}/product/{product}', 'CartProductController@destroy')->name('carts.product.destroy');

    // Bulk methods
    Route::post('carts/{cart}/items', 'CartItemController@store')->name('carts.items.store');
    Route::delete('carts/{cart}/items/{cartItem}', 'CartItemController@destroy')->name('carts.items.destroy');

    Route::post('carts/{cart}/purchase', 'CartPurchaseController@store')->name('carts.purchase.store');
    Route::post('carts/{cart}/abandon', 'CartAbandonController@store')->name('carts.abandon.store');

    Route::post('purchases/{purchase}/apply', 'PurchaseApplyController@store')->name('purchase.apply.store');
});
