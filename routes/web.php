<?php
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BannerProductController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\FeaturesCategoryController;
use App\Http\Controllers\FeaturesProductController;
use App\Http\Controllers\MarketingProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TodayHotDealController;
use App\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])
    ->prefix('dashboard')
    ->group(function () {

        // Dashboard
        Route::get('/', fn() => view('pages.dashboard.ecommerce'))
            ->name('dashboard');

        // Inventory - Category
        Route::prefix('inventory/category')
            ->name('inventory.category.')
            ->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index'])
                ->name('index');

            Route::get('/create-category', [ProductCategoryController::class, 'create'])
                ->name('create');

            Route::get('/create-category/{id}', [ProductCategoryController::class, 'show'])
                ->name('edit');

            Route::delete('/create-category/{id}', [ProductCategoryController::class, 'destroy'])
                ->name('destroy');

            Route::post('/', [ProductCategoryController::class, 'store'])
                ->name('store');

            Route::put('/{id}', [ProductCategoryController::class, 'update'])
                ->name('update');
        });

        // Inventory - Category
        Route::prefix('inventory/product')
            ->name('inventory.product.')
            ->group(function () {
            Route::get('/', [ProductController::class, 'index'])
                ->name('index');

            Route::get('/create-product', [ProductController::class, 'create'])
                ->name('create');

            Route::get('/variant/{id}', [ProductController::class, 'variant'])
                ->name('variant');

            Route::post('/variant/store', [ProductController::class, 'variantStore'])
                ->name('variantStore');

            Route::get('/create-product/{id}', [ProductController::class, 'show'])
                ->name('edit');

            Route::delete('/create-product/{id}', [ProductController::class, 'destroy'])
                ->name('destroy');

            Route::post('/', [ProductController::class, 'store'])
                ->name('store');

            Route::patch('/{id}', [ProductController::class, 'update'])
                ->name('update');
            Route::delete('variant/{id}', [ProductController::class, 'destroyVariant'])
                ->name('destroyVariant');

            Route::put('variant/{id}', [ProductController::class, 'variantUpdate'])
                ->name('variantUpdate');

            Route::get('get-attributes/{variantId}', [ProductController::class, 'getAttributesByVariant'])
                ->name('inventory.product.getAttributes');

            Route::delete('destroy-image/{id}', [ProductController::class, 'destroyImage'])
                ->name('destroyImage');

            Route::post('set-primary/{id}', [ProductController::class, 'setPrimary'])
                ->name('primary');

        });



        // Variant related api
    
        Route::prefix('variants')
            ->name('variants.')
            ->group(function () {
                Route::get('/', [VariantController::class, 'index'])
                    ->name('index');

                Route::get('/create', [VariantController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [VariantController::class, 'show'])
                    ->name('edit');

                Route::delete('/{id}', [VariantController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/', [VariantController::class, 'store'])
                    ->name('store');

                Route::put('/{id}', [VariantController::class, 'update'])
                    ->name('update');

            });

        Route::prefix('attributes')
            ->name('attributes.')
            ->group(function () {
                Route::get('/', [AttributeController::class, 'index'])
                    ->name('index');

                Route::get('/create', [AttributeController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [AttributeController::class, 'show'])
                    ->name('edit');

                Route::delete('/{id}', [AttributeController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/', [AttributeController::class, 'store'])
                    ->name('store');

                Route::put('/{id}', [AttributeController::class, 'update'])
                    ->name('update');
            });


        Route::prefix('features-category')
            ->name('features.category.')
            ->group(function () {
                Route::get('/', [FeaturesCategoryController::class, 'index'])
                    ->name('index');

                Route::get('/create', [FeaturesCategoryController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [FeaturesCategoryController::class, 'show'])
                    ->name('edit');

                Route::delete('/{id}', [FeaturesCategoryController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/', [FeaturesCategoryController::class, 'store'])
                    ->name('store');

                Route::put('/{id}', [FeaturesCategoryController::class, 'update'])
                    ->name('update');
            });


        Route::prefix('mapping-products')
            ->name('mapping.product.')
            ->group(function () {
                Route::get('/', [FeaturesProductController::class, 'index'])
                    ->name('index');

                Route::get('/create', [FeaturesProductController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [FeaturesProductController::class, 'show'])
                    ->name('edit');

                Route::delete('/{id}', [FeaturesProductController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/', [FeaturesProductController::class, 'store'])
                    ->name('store');

                Route::put('/{id}', [FeaturesProductController::class, 'update'])
                    ->name('update');
            });

        Route::prefix('today-hot-deal')
            ->name('todayHotDeal.')
            ->group(function () {
                Route::get('/', [TodayHotDealController::class, 'index'])
                    ->name('index');

                Route::get('/create', [TodayHotDealController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [TodayHotDealController::class, 'show'])
                    ->name('edit');

                Route::delete('/{id}', [TodayHotDealController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/', [TodayHotDealController::class, 'store'])
                    ->name('store');

                Route::put('/{id}', [TodayHotDealController::class, 'update'])
                    ->name('update');
            });


        Route::prefix('blog-category')
            ->name('blogCategory.')
            ->group(function () {
                Route::get('/', [BlogCategoryController::class, 'index'])
                    ->name('index');

                Route::get('/create', [BlogCategoryController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [BlogCategoryController::class, 'show'])
                    ->name('edit');

                Route::delete('/{id}', [BlogCategoryController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/', [BlogCategoryController::class, 'store'])
                    ->name('store');

                Route::put('/{id}', [BlogCategoryController::class, 'update'])
                    ->name('update');

            });

        Route::prefix('blogs')
            ->name('blogs.')
            ->group(function () {
                Route::get('/', [BlogController::class, 'index'])
                    ->name('index');
                Route::get('/create', [BlogController::class, 'create'])
                    ->name('create');

                Route::get('/{id}', [BlogController::class, 'show'])
                    ->name('edit');
                Route::post('/', [BlogController::class, 'store'])
                    ->name('store');
                Route::put('/{id}', [BlogController::class, 'update'])
                    ->name('update');
                Route::delete('/{id}', [BlogController::class, 'destroy'])
                    ->name('destroy');

            });

        Route::prefix('marketing-product')
            ->name('marketingProduct.')
            ->group(function () {
                Route::get('/', [MarketingProductController::class, 'index'])
                    ->name('index');
                Route::get('/create', [MarketingProductController::class, 'create'])
                    ->name('create');
                Route::get('/{id}', [MarketingProductController::class, 'show'])
                    ->name('edit');
                Route::post('/', [MarketingProductController::class, 'store'])
                    ->name('store');
                Route::patch('/{id}', [MarketingProductController::class, 'update'])
                    ->name('update');
                Route::delete('/{id}', [MarketingProductController::class, 'destroy'])
                    ->name('destroy');

            });


        //        banner product
    
        Route::prefix('banners')
            ->name('banners.')
            ->group(function () {
                Route::get('/', [BannerProductController::class, 'index'])
                    ->name('index');
                Route::post('/', [BannerProductController::class, 'store'])
                    ->name('store');

            });

        Route::prefix('about-us')
            ->name('aboutUs.')
            ->group(function () {
                Route::get('/', [AboutUsController::class, 'index'])
                    ->name('index');
                Route::post('/', [AboutUsController::class, 'store'])
                    ->name('store');

            });

        Route::prefix('disclaimer')
            ->name('disclaimer.')
            ->group(function () {
                Route::get('/', [CommonController::class, 'indexDisclaimer'])
                    ->name('index');
                Route::post('/', [CommonController::class, 'storeDisclaimer'])
                    ->name('store');
            });

        Route::prefix('packaging')
            ->name('packaging.')
            ->group(function () {
                Route::get('/', [CommonController::class, 'indexPackaging'])
                    ->name('index');
                Route::post('/', [CommonController::class, 'storePackaging'])
                    ->name('store');
            });
        Route::prefix('terms-conditions')
            ->name('termsConditions.')
            ->group(function () {
                Route::get('/', [CommonController::class, 'indexConditions'])
                    ->name('index');
                Route::post('/', [CommonController::class, 'storeConditions'])
                    ->name('store');
            });

        Route::prefix('shipping-policy')
            ->name('shippingPolicy.')
            ->group(function () {
                Route::get('/', [CommonController::class, 'indexShippingPolicy'])
                    ->name('index');
                Route::post('/', [CommonController::class, 'storeShippingPolicy'])
                    ->name('store');
            });


        Route::prefix('privacy-policy')
            ->name('privacyPolicy.')
            ->group(function () {
                Route::get('/', [CommonController::class, 'indexPrivacyPolicy'])
                    ->name('index');
                Route::post('/', [CommonController::class, 'storePrivacyPolicy'])
                    ->name('store');
            });

        Route::prefix('return-and-refund')
            ->name('returnAndRefund.')
            ->group(function () {
                Route::get('/', [CommonController::class, 'indexReturnAndRefund'])
                    ->name('index');
                Route::post('/', [CommonController::class, 'storeReturnAndRefund'])
                    ->name('store');
            });

    });


Route::get('/', action: function () {
    return  DB::connection()->getMongoClient();
});
