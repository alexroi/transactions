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
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('cards')->uses('CardsController@index')->name('site.cards');
    Route::get('cards/create')->uses('CardsController@create')->name('site.cards.create');
    Route::post('cards')->uses('CardsController@store')->name('site.cards.store');

    Route::middleware('card.owner')->group(function () {
        Route::get('cards/{card}')->uses('CardsController@show')->name('site.cards.show');
        Route::get('cards/{card}/replenish')->uses('CardsController@replenish')->name('site.cards.replenish');
        Route::post('cards/{card}/replenish')->uses('CardsController@replenishStore')->name('site.cards.replenish.store');
        Route::get('cards/{card}/withdraw')->uses('CardsController@withdraw')->name('site.cards.withdraw');
        Route::post('cards/{card}/withdraw')->uses('CardsController@withdrawStore')->name('site.cards.withdraw.store');
        Route::get('cards/{card}/transfer')->uses('CardsController@transfer')->name('site.cards.transfer');
        Route::post('cards/{card}/transfer')->uses('CardsController@transferStore')->name('site.cards.transfer.store');
    });
});

