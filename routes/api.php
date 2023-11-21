<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {


    // Route for user registration
    Route::post('/users', 'App\Http\Controllers\AuthController@register');
// Route for user login
    Route::post('/users/login', 'App\Http\Controllers\AuthController@login');

    Route::post('/users/refresh', 'App\Http\Controllers\AuthController@refresh');


    Route::group(['middleware' => ['auth:api','api']], function() {
        Route::get('/users', 'App\Http\Controllers\AuthController@index');


//        Route::apiResource('projects', ProjectController::class);
//        Route::apiResource('tasks', TaskController::class);

        Route::post('/projects/{project}/tasks/{task}/assign', 'App\Http\Controllers\TaskController@assignTask');
        Route::get('/projects/statistics', 'App\Http\Controllers\ProjectController@projectStatistics');



            Route::get('projects/', 'App\Http\Controllers\ProjectController@index');
            Route::post('projects/', 'App\Http\Controllers\ProjectController@store');
        Route::group(['middleware' => ['check.project.deadline']], function() {
            Route::put('projects/{id}', 'App\Http\Controllers\ProjectController@update');
            Route::get('projects/{id}', 'App\Http\Controllers\ProjectController@show');
            Route::get('projects/{id}/tasks', 'App\Http\Controllers\ProjectController@getProjectTask');
            Route::delete('projects/{id}', 'App\Http\Controllers\ProjectController@destroy');
        });


        Route::get('tasks/', 'App\Http\Controllers\TaskController@index');
        Route::post('tasks/', 'App\Http\Controllers\TaskController@store');
        Route::put('tasks/{id}', 'App\Http\Controllers\TaskController@update');
        Route::get('tasks/{id}', 'App\Http\Controllers\TaskController@show');
        Route::get('tasks/{id}/tasks', 'App\Http\Controllers\TaskController@getProjectTask');
        Route::delete('tasks/{id}', 'App\Http\Controllers\TaskController@destroy');

    });


});


Route::fallback(function(){
    return response()->json([
        'message' => 'Endpoint not found'], 404);
});
