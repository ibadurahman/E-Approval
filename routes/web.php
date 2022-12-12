<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/user',App\Http\Controllers\UserController::class);
Route::resource('/dealer',App\Http\Controllers\DealerController::class);
Route::resource('/position',App\Http\Controllers\PositionController::class);
Route::resource('/dealerApproveRule',App\Http\Controllers\DealerApproveRuleController::class);
Route::resource('/subItem',App\Http\Controllers\SubItemController::class);
Route::resource('/item',App\Http\Controllers\ItemController::class);

Route::post('/purchaseOrder/getSubItem',[App\Http\Controllers\PurchaseOrderController::class,'getSubItem']);
Route::get('/purchaseOrder/{dealer}/create',[App\Http\Controllers\PurchaseOrderController::class,'create']);
Route::resource('/purchaseOrder',App\Http\Controllers\PurchaseOrderController::class);
