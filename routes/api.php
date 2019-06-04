<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//获取tipnews
Route::get('gettipnews', 'Api\ApiController@getTipNews')->name('api.gettipnews');
//获取幻灯片
Route::get('getsides', 'Api\ApiController@getSides')->name('api.getsides');
//获取专题
Route::get('gettopic', 'Api\ApiController@getTopic')->name('api.gettopic');



Route::group(['namespace' => 'Api', 'prefix' => 'api', 'middleware' => ['auth']], function () {
    //---------------招聘-----------------
    Route::get('job/index', 'JobController@index')->name('member.job.index');
    Route::get('job/create', 'JobController@create')->name('member.job.create');
    Route::get('job/{id}/update/', 'JobController@update')->name('member.job.update');
    Route::post('job/store', 'JobController@store')->name('member.job.store');
    Route::get('job/{id}/destroy', 'JobController@destroy')->name('member.job.destroy');
});
