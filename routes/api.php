<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// no auth required to view standard/s
Route::get('standards/{id}', 'StandardController@show');
Route::get('config', 'ConfigurationController@show');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('list', 'AssessmentController@list');
    Route::get('assessments/{id}', 'AssessmentController@show');
    Route::get('results/{id}', 'ResultController@show');

    Route::post('assessments', 'AssessmentController@store');
    Route::put('assessments', 'AssessmentController@update');
    //Route::post('assessments/reassess/{result_id}', 'AssessmentController@reassess');

    Route::post('assessments/{assessment}/result');
    Route::post('results/create', 'ResultController@store');
    Route::post('assessments/edit/{id}/{result_id}', 'AssessmentController@edit');
    Route::post('results/update/{id}', 'ResultController@update');

});


