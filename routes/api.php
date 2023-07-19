<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

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

// get
Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']);
Route::get('contact/list',[RouteController::class,'contactList']);
// Route::get('category/list/{id}',[RouteController::class,'categor'])

// post
Route::post('create/category',[RouteController::class,'categoryCreate']);
Route::post('delete/category',[RouteController::class,'deleteCategory']);
Route::post('category/details',[RouteController::class,'categoryDetails']);
Route::post('update/category',[RouteController::class,'updateCategory']);
