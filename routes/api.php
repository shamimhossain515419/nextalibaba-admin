<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FeaturesCategoryController;
use App\Http\Controllers\OrderController;
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
Route::get('/get-product-by-slug/{slug}', [ProductController::class, 'getProductBySlug']);
Route::get('/get-product-by-feature-category', [ProductController::class, 'getProductFeaturesWise']);

Route::get('/get-today-hot-deals', [ProductController::class, 'getTodayHotDeal']);
Route::get('/get-top-pricing', [ProductController::class, 'getTopRateProducts']);
Route::get('/get-banners', [ProductController::class, 'getBanner']);

Route::get('/get-all-features', [FeaturesCategoryController::class, 'indexWebView']);

Route::get('/get-all-blogs', [BlogController::class, 'allBlog']);
Route::get('/get-all-blog-category', [BlogController::class, 'allBlogCategory']);
Route::get('/get-blog-by-category/{slug}', [BlogController::class, 'getBlogByCategory']);
Route::get('/get-single-blog/{slug}', [BlogController::class, 'getSingleProductBySlug']);


//order related api

Route::post('/place-order', [OrderController::class, 'placeOrder']);
