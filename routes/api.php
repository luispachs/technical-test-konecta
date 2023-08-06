<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProductController,SaleController};

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
Route::delete('/product/delete/{id}',[ProductController::class,'deleteAction'])->name('delete.product');
Route::get('/product/get/{name}',[ProductController::class,'getProduct'])->name('get.product');
Route::get('/product/stock/{id}',[SaleController::class,'getStock'])->name('get.stock');
Route::post('/sale/pay',[SaleController::class,'soldAction'])->name('set.sale');



