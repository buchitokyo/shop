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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


    /**  商品リストを表示するページ ProductController
    *    カートの中身を表示、内容変更するページ CartController
    *    Ajaxで商品データを取得するページ Ajax/ProductController
    *    Ajaxでカートの中身を｛参照／追加／変更／削除｝するページ　Ajax\CartController
    **/

Route::get('/products', 'Cart\ProductController@index')->name('cart.product.index');
Route::get('/carts', 'Cart\CartController@index')->name('cart.cart.index');
Route::resource('ajax/products', 'Ajax\ProductController')
    ->only(['index']);
Route::resource('ajax/carts', 'Ajax\CartControllerr')
    ->only(['index', 'store', 'destroy']);
