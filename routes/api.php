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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
     return $request->user();
 });
*/

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('signup', [App\Http\Controllers\AuthController::class, 'signup']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);

});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('/employee', App\Http\Controllers\Api\EmployeeController::class);
    Route::apiResource('/supplier', App\Http\Controllers\Api\SupplierController::class);
    Route::apiResource('/category', App\Http\Controllers\Api\CategoryController::class);
    Route::apiResource('/product', App\Http\Controllers\Api\ProductController::class);
    Route::apiResource('/expense', App\Http\Controllers\Api\ExpenseController::class);
    Route::apiResource('/customer', App\Http\Controllers\Api\CustomerController::class);

    Route::Post('/salary/paid/{id}', [App\Http\Controllers\Api\SalaryController::class,'Paid']);
    Route::Get('/salary', [App\Http\Controllers\Api\SalaryController::class, 'AllSalary']);

    Route::Get('/salary/view/{id}', [App\Http\Controllers\Api\SalaryController::class, 'ViewSalary']);
    Route::Get('/edit/salary/{id}', [App\Http\Controllers\Api\SalaryController::class, 'EditSalary']);
    Route::Post('/salary/update/{id}', [App\Http\Controllers\Api\SalaryController::class, 'SalaryUpdate']);

    Route::Post('/stock/update/{id}', [App\Http\Controllers\Api\ProductController::class, 'StockUpdate']);

    Route::Get('/getting/product/{id}', [App\Http\Controllers\Api\PosController::class, 'GetProduct']);

    // Add to cart Route
    Route::Get('/addToCart/{id}', [App\Http\Controllers\Api\CartController::class, 'AddToCart']);
    Route::Get('/cart/product', [App\Http\Controllers\Api\CartController::class, 'CartProduct']);

    Route::Get('/remove/cart/{id}', [App\Http\Controllers\Api\CartController::class, 'removeCart']);

    Route::Get('/increment/{id}', [App\Http\Controllers\Api\CartController::class, 'increment']);
    Route::Get('/decrement/{id}', [App\Http\Controllers\Api\CartController::class, 'decrement']);

    // Vat Route
    Route::Get('/vats', [App\Http\Controllers\Api\CartController::class, 'Vats']);

    Route::Post('/orderdone', [App\Http\Controllers\Api\PosController::class, 'OrderDone']);

    // Order Route
    Route::Get('/orders', [App\Http\Controllers\Api\OrderController::class, 'TodayOrder']);

    Route::Get('/order/details/{id}', [App\Http\Controllers\Api\OrderController::class, 'OrderDetails']);
    Route::Get('/order/orderdetails/{id}', [App\Http\Controllers\Api\OrderController::class, 'OrderDetailsAll']);

    Route::Post('/search/order', [App\Http\Controllers\Api\PosController::class, 'SearchOrderDate']);

    // Admin Dashboard Route

    Route::Get('/today/sell', [App\Http\Controllers\Api\PosController::class, 'TodaySell']);
    Route::Get('/today/income', [App\Http\Controllers\Api\PosController::class, 'TodayIncome']);
    Route::Get('/today/due', [App\Http\Controllers\Api\PosController::class, 'TodayDue']);
    Route::Get('/today/expense', [App\Http\Controllers\Api\PosController::class, 'TodayExpense']);
    Route::Get('/today/stockout', [App\Http\Controllers\Api\PosController::class, 'Stockout']);
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});
