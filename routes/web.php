<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AssessmentController;
use Illuminate\Http\Request;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/help', function () {
    return view('help');
});

// note: assessment routes limited to logged in users (see controller)

Route::get('/assessment_list', function () {
    return view('assessment_list');
})->name('assessment_list')->middleware('auth:sanctum');

Route::get('/assessment', function () {
    return view('assessment');
})->middleware('auth:sanctum');

Route::get('/assessment/{result_id}', function () {
    return view('assessment');
})->name('getResultId')->middleware('auth:sanctum');

Route::get('/assessments/{id}', function () {
    return view('assessment_result');
})->middleware('auth:sanctum');


Route::get('reassessment/{result_id}', [AssessmentController::class, 'reassess'])
    ->middleware('auth:sanctum');


Auth::routes();

