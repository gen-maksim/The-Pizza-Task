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

Route::get('/', 'OrderController@menu')->name('menu');
Route::get('menu', 'OrderController@menu')->name('menu');
Route::post('order', 'OrderController@store')->name('order.store');
Route::post('currency', 'OrderController@setCurrency')->name('currency.set');

Route::get('cart', 'CartController@cart')->name('cart');
Route::post('cart/addPizza', 'CartController@addPizza')->name('cart.addPizza');
Route::post('cart/deletePizza', 'CartController@deletePizza')->name('cart.deletePizza');
Route::post('cart/removePizza', 'CartController@removePizza')->name('cart.removePizza');

Route::get('login', 'AuthController@showLogin')->name('login');
Route::post('login', 'AuthController@login')->name('login');
Route::get('register', 'AuthController@showRegister')->name('register');
Route::post('register', 'AuthController@register')->name('register');
Route::get('logout', 'AuthController@logout')->name('logout');
