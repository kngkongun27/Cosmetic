<?php

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BlogAdController;
use App\Http\Controllers\Front\BotManController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Admin\ContactAdController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Repositories\Product\ProductRepositoryInterface;
// chatbot
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;



Route::get('/', [FrontHomeController::class, 'index']);


Route::prefix('/shop')->group(function () {
    Route::get('/product/{id}', [ShopController::class, 'show'])->name('shop.product');
    Route::post('/product/{id}', [ShopController::class, 'postComment']);
    Route::get('', [ShopController::class, 'index']);
    Route::get('category/{categoryName}', [ShopController::class, 'category']);
});
Route::prefix('cart')->group(function () {
    Route::get('add', [CartController::class, 'add']);
    Route::get('/', [CartController::class,  'index']);
    Route::get('delete', [CartController::class,  'delete']);
    Route::get('destroy', [CartController::class,  'destroy']);
    Route::get('update', [CartController::class,  'update']);
});


Route::prefix('checkout')->group(function () {
    Route::get('', [CheckoutController::class, 'index']);
    Route::post('/', [CheckoutController::class, 'addOrder']);
    Route::get('/result', [CheckoutController::class, 'result']);
});


Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});


Route::prefix('account')->group(function () {
    Route::get('login', [AccountController::class, 'login']);
    Route::post('login', [AccountController::class, 'checkLogin']);
    Route::get('logout', [AccountController::class, 'logout']);

    Route::get('register', [AccountController::class, 'register']);
    Route::post('register', [AccountController::class, 'postRegister']);


    Route::prefix('my-order')->middleware('CheckMemberLogin')->group(function () {
        Route::get('/', [AccountController::class, 'myOrderIndex']);
        Route::get('/{$id}', [AccountController::class, 'myOrderShow']);
    });
});

Route::get('/comment', [ShopController::class, 'getComment']);
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/getBlog', [BlogController::class, 'getBlog']);
Route::get('/chi-tiet-blog/{slug}', [BlogController::class, 'detail']);
Route::get('/getBlogDetail/{slug}', [BlogController::class, 'getBlogDetail']);
// Chatbot
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/chatbot', function () {
    return view('chatbot');
});
// Dashboard ( Admin ) 

Route::prefix('admin')->middleware('CheckAdminLogin')->group(function () {

    Route::redirect('', 'admin/user');
    Route::resource('user', UserController::class);

    Route::prefix('login')->group(function () {
        Route::get('', [HomeController::class, 'getLogin'])->withoutMiddleware('CheckAdminLogin');
        Route::post('', [HomeController::class, 'postLogin'])->withoutMiddleware('CheckAdminLogin');
    });
    Route::get('logout', [HomeController::class, 'logout']);


    // Blog
    Route::resource('blog', BlogAdController::class);
    Route::put('blog/{id}/edit', [BlogAdController::class, 'update']);
    Route::delete('/blog{id}', [BlogAdController::class, 'destroy']);

    // Category
    Route::resource('category', ProductCategoryController::class);
    Route::put('/category/{id}/edit', [ProductCategoryController::class, 'update']);
    Route::delete('/category/{id}', [ProductCategoryController::class, 'destroy']);


    // Brand
    Route::resource('brand', BrandController::class);
    Route::put('/brand/{id}/edit', [BrandController::class, 'update']);
    Route::delete('/brand/{id}', [BrandController::class, 'destroy']);

    // Product 
    Route::resource('product', ProductController::class);
    Route::put('/product{id}/edit', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);


    

    // Product Detail
    Route::resource('product/{product_id}/detail', ProductDetailController::class);
    Route::put('product/{product_id}/detail/{product_detail_id}/edit', [ProductDetailController::class, 'update']);
    Route::delete('product/{product_id}/detail/{product_detail_id}', [ProductDetailController::class, 'destroy']);

    // Order 
    Route::resource('order', OrderController::class);

    Route::post('/updateStatus', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');


    // Statistical
    Route::get('/statistical', [StatisticalController::class, 'index'])->name('admin.statistical.index');
    Route::get('/statistical/get-profit', [StatisticalController::class, 'getProfit'])->name('admin.statistical.profit');
    Route::get('/statistical/get-top-products', [StatisticalController::class, 'getTopProducts'])->name('admin.statistical.topProducts');
    Route::get('/statistical/get-top-customers', [StatisticalController::class, 'getTopCustomers'])->name('admin.statistical.topCustomers');
    Route::get('/statistical/get-orders-summary', [StatisticalController::class, 'getOrdersSummary'])->name('admin.statistical.ordersSummary');

    // COntact
    Route::get('/contact', [ContactAdController::class, 'index'])->name('contact.index');
    Route::delete('/contact/{id}', [ContactAdController::class, 'destroy'])->name('contact.destroy');
});
Route::prefix('admin/product/{product_id}/image')->group(function () {
        Route::get('/', [ProductImageController::class, 'index'])->name('product.image.index');
        Route::post('/', [ProductImageController::class, 'store'])->name('product.image.store'); // thêm ảnh
        Route::delete('/{product_image_id}', [ProductImageController::class, 'destroy'])->name('product.image.destroy'); // xóa ảnh
    });
