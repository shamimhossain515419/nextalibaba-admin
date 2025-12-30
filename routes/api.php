<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\FeaturesCategoryController;
use App\Http\Controllers\MarketingProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-orders', [OrderController::class, 'myAllOrders']);
    Route::get('/my-address', [OrderController::class, 'myAddress']);
    Route::post('/shipping-address', [OrderController::class, 'saveAddress']);
});


Route::get('/get-all-category', [ProductCategoryController::class, 'indexWebView']);
Route::get('/get-product-by-category', [ProductController::class, 'getProductByCategory']);
Route::get('/get-product-by-slug/{slug}', [ProductController::class, 'getProductBySlug']);
Route::get('/get-product-by-feature-category', [ProductController::class, 'getProductFeaturesWise']);

Route::get('/get-today-hot-deals', [ProductController::class, 'getTodayHotDeal']);
Route::get('/get-top-pricing', [ProductController::class, 'getTopRateProducts']);
Route::get('/get-banners', [ProductController::class, 'getBanner']);

Route::get('/get-product-by-search', [ProductController::class, 'getProductBySearch']);



Route::get('/get-all-features', [FeaturesCategoryController::class, 'indexWebView']);

Route::get('/get-all-blogs', [BlogController::class, 'allBlog']);
Route::get('/get-all-blog-category', [BlogController::class, 'allBlogCategory']);
Route::get('/get-blog-by-category/{slug}', [BlogController::class, 'getBlogByCategory']);
Route::get('/get-single-blog/{slug}', [BlogController::class, 'getSingleProductBySlug']);


//order related api

Route::post('/place-order', [OrderController::class, 'placeOrder']);
Route::get('/get-order/{invoice}', [OrderController::class, 'invoice']);

//common api

Route::get('/about-us', [AboutUsController::class, 'about']);


Route::get('/disclaimer', [CommonController::class, 'disclaimer']);
Route::get('/packaging', [CommonController::class, 'packaging']);
Route::get('/terms-conditions', [CommonController::class, 'conditions']);
Route::get('/shipping-policy', [CommonController::class, 'shippingPolicy']);
Route::get('/privacy-policy', [CommonController::class, 'privacyPolicy']);
Route::get('/return-and-refund', [CommonController::class, 'privacyReturnAndRefund']);

Route::get('/marketing-product', [MarketingProductController::class, 'indexWebView']);
