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

use App\Http\Controllers\SharedListsApiController;
use App\Http\Controllers\ListItemApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiDummyController;


// Protected routes
Route::group(['middleware' => ['auth:sanctum', 'cors']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    // Shared lists
    Route::post('/shared_lists/{id}', [SharedListsApiController::class, 'index']);
    Route::get('/shared_lists/{id}/allowed-users', [SharedListsApiController::class, 'index_allowedUsers']);
    Route::post('/shared_lists', [SharedListsApiController::class, 'create']);
    Route::put('/shared_lists/{id}', [SharedListsApiController::class, 'update']);
    Route::delete('/shared_lists/{id}', [SharedListsApiController::class, 'delete']);

    // List items
    Route::post('/list_items/{list_id}', [ListItemApiController::class, 'index']);
    Route::post('/list_items', [ListItemApiController::class, 'create']);
    Route::put('/list_items/{id}', [ListItemApiController::class, 'update']);
    Route::delete('/list_items/{id}', [ListItemApiController::class, 'delete']);

});

//Public routes
Route::group(['middleware' => ['cors']], function() {
    Route::post('/register', [AuthController::class, 'register']);
    //Route::post('/login', [AuthController::class, 'login']);
    Route::post('/search', [AuthController::class, 'search']);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware('cors')->get('/test', [ApiDummyController::class, 'index']);
//Route::middleware('cors')->post('/testpost', [ApiDummyController::class, 'postReq']);
Route::middleware('cors')->post('/login', [AuthController::class, 'login']);
Route::get('/test2', [ApiDummyController::class, 'index']);

Route::middleware(['cors'])->group(function () {
    Route::post('/testpost', [ApiDummyController::class, 'postReq']);
});

Route::any("/", function(){
    return [
        'message' => 'Wrong route path.'
    ];
});
