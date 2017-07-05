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



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{pageId}', function($pageId){
    return view('page',['pageId' => $pageId]);
});
Route::get('comments/{pageId}', 'CommentController@index');
Route::post('comments', 'CommentController@store');
Route::post('comments/{commentId}/{type}', 'CommentController@update');