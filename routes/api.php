<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function (){

});


Route::get('/get-all-category', [ProductCategoryController::class, 'indexWebView']);

Route::get('/get-product-by-category', [ProductController::class, 'getProductByCategory']);


