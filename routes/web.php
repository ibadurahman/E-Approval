<?php

use Illuminate\Support\Facades\Auth;
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
Route::post('/purchaseOrder/getItemName',[App\Http\Controllers\PurchaseOrderController::class,'getItemName']);
Route::post('/purchaseOrder/getSubItemName',[App\Http\Controllers\PurchaseOrderController::class,'getSubItemName']);
Route::post('/purchaseOrder/getApprovalData',[App\Http\Controllers\PurchaseOrderController::class,'getApprovalData']);
Route::post('/purchaseOrder/uploadFiles',[App\Http\Controllers\PurchaseOrderController::class,'uploadFiles']);
Route::get('/purchaseOrder/{dealer}/create',[App\Http\Controllers\PurchaseOrderController::class,'create']);
Route::get('/purchaseOrder/{purchaseOrder}/downloadFile/{fileName}',[App\Http\Controllers\PurchaseOrderController::class,'downloadFile']);
Route::resource('/purchaseOrder',App\Http\Controllers\PurchaseOrderController::class);

Route::get('/closePurchaseOrder/{dealer}/create/{purchaseOrder}',[App\Http\Controllers\ClosePurchaseOrderController::class,'create']);
Route::resource('/closePurchaseOrder',App\Http\Controllers\ClosePurchaseOrderController::class);

Route::get('/approval/{purchaseOrder}/downloadFile/{fileName}',[App\Http\Controllers\ApprovalController::class,'downloadFile']);
Route::post('/approval/applySign',[App\Http\Controllers\ApprovalController::class,'applySign']);
Route::resource('/approval',App\Http\Controllers\ApprovalController::class);

Route::post('/dealerApproveOrganization/getPersonCharge',[App\Http\Controllers\DealerApproveOrganizationController::class,'getPersonCharge']);
Route::post('/dealerApproveOrganization/getPosition',[App\Http\Controllers\DealerApproveOrganizationController::class,'getPosition']);
Route::resource('/dealerApproveOrganization',App\Http\Controllers\DealerApproveOrganizationController::class);