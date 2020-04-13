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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function ($router) {

  Route::post('register', 'AuthController@register'); 
  Route::post('login', 'AuthController@login');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
  Route::post('me', 'AuthController@me');

});
Route::apiResources(['course' => 'API\CourseController']);
//Course Controller

Route::get('course', 'API\CourseController@index')->name('course');
Route::get('course/{id}', 'API\CourseController@show')->name('showCourse');
Route::post('course', 'API\CourseController@store')->name('storeCourse');
Route::put('course/{id}', 'API\CourseController@update')->name('updateCourse');
Route::delete('course/{id}', 'API\CourseController@delete')->name('deleteCourse');


Route::get('topic', 'API\TopicController@index')->name('topic');
Route::get('topic/past', 'API\TopicController@past')->name('past');
Route::get('topic/course', 'API\TopicController@course')->name('topic_course');

Route::get('topic/{id}', 'API\TopicController@show')->name('showTopic');
Route::post('topic', 'API\TopicController@store')->name('storeTopic');
Route::put('topic/{id}', 'API\TopicController@update')->name('updateTopic');
Route::delete('topic/{id}', 'API\TopicController@delete')->name('deleteTopic');
