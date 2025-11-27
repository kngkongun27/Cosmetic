<?php

namespace App\Providers;


use Carbon\Carbon;
use App\Models\Luottruycap;
use App\Service\Blog\BlogService;
use App\Service\User\UserService;
use App\Service\Brand\BrandService;
use App\Service\Order\OrderService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Service\Product\ProductService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\User\UserRepository;
use App\Service\Blog\BlogServiceInterface;
use App\Service\User\UserServiceInterface;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Order\OrderRepository;
use App\Service\Brand\BrandServiceInterface;
use App\Service\Order\OrderServiceInterface;
use App\Repositories\Product\ProductRepository;
use App\Service\OrderDetail\OrderDetailService;
use App\Service\Product\ProductServiceInterface;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Service\ProductComment\ProductCommentService;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Service\ProductCategory\ProductCategoryService;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Repositories\ProductComment\ProductCommentRepository;
use App\Service\ProductComment\ProductCommentServiceInterface;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Service\ProductCategory\ProductCategoryServiceInterface;
use App\Repositories\ProductComment\ProductCommentRepositoryInterface;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         //Product
         $this->app->singleton(
            abstract: ProductRepositoryInterface::class, 
            concrete: ProductRepository::class
         );

         $this->app->singleton(
            abstract: ProductServiceInterface::class,
            concrete: ProductService::class
         );

          //ProductComment
          $this->app->singleton(
            abstract: ProductCommentRepositoryInterface::class, 
            concrete: ProductCommentRepository::class
         );

         $this->app->singleton(
            abstract: ProductCommentServiceInterface::class,
            concrete: ProductCommentService::class
         );


         // Blog 
         $this->app->singleton(
            abstract: BlogRepositoryInterface::class, 
            concrete: BlogRepository::class
         );

         $this->app->singleton(
            abstract: BlogServiceInterface::class,
            concrete: BlogService::class
         );

          // ProductCategory
          $this->app->singleton(
            abstract: ProductCategoryRepositoryInterface::class, 
            concrete: ProductCategoryRepository::class
         );

         $this->app->singleton(
            abstract: ProductCategoryServiceInterface::class,
            concrete: ProductCategoryService::class
         );

          // Brand
          $this->app->singleton(
            abstract: BrandRepositoryInterface::class, 
            concrete: BrandRepository::class
         );

         $this->app->singleton(
            abstract: BrandServiceInterface::class,
            concrete: BrandService::class
         );
         
           // User
           $this->app->singleton(
            abstract: UserRepositoryInterface::class, 
            concrete: UserRepository::class
         );

         $this->app->singleton(
            abstract: UserServiceInterface::class,
            concrete: UserService::class
         );

         // Order
         $this->app->singleton(
            abstract: OrderRepositoryInterface::class, 
            concrete: OrderRepository::class
         );

         $this->app->singleton(
            abstract: OrderServiceInterface::class,
            concrete: OrderService::class
         );


         // OrderDetail
         $this->app->singleton(
            abstract: OrderDetailRepositoryInterface::class, 
            concrete: OrderDetailRepository::class
         );

         $this->app->singleton(
            abstract: OrderDetailServiceInterface::class,
            concrete: OrderDetailService::class
         );
         
         
       
       
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        //

        
        
    }
}
