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
Route::group(['middleware' => 'web'], function () {
    Route::get('/welcome', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');


        /**  商品リストを表示するページ ProductController
        *    カートの中身を表示、内容変更するページ CartController
        *    Ajaxで商品データを取得するページ Ajax/ProductController
        *    Ajaxでカートの中身を｛参照／追加／変更／削除｝するページ　Ajax\CartController
        **/

    Route::get('/products', 'Cart\ProductController@index')->name('product.index');
    Route::get('/carts', 'Cart\CartController@index')->name('cart.index');
    Route::get('/user/payment', 'Payment\PaymentController@getCurrentPayment')->name('payment.index');
    Route::post('/payment/form', 'Payment\PaymentController@getPaymentForm')->name('payment.form');
    Route::post('/pay', 'Payment\PaymentController@pay')->name('payment.pay');
    Route::post('/payment/store', 'Payment\PaymentController@storePaymentInfo')->name('payment.store');


    // 課金
    Route::post('ajax/Payment/oneTimePayment', '\Ajax\PaymentController@oneTimePayment');
    Route::get('ajax/Payment/status', '\Ajax\PaymentControllerController@status');


    Route::resource('ajax/products', 'Ajax\ProductController')
        ->only(['index']);
    Route::resource('ajax/carts', 'Ajax\CartController')
        ->only(['index', 'store', 'destroy']);

});
