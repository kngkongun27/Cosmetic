<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Service\Blog\BlogServiceInterface;
use App\Service\Product\ProductServiceInterface;

class HomeController extends Controller
{
    //
    private $productService;
    private $blogService;

    public function __construct(
        ProductServiceInterface $productService,
        BlogServiceInterface $blogService
    ) {
        $this->productService = $productService;
        $this->blogService = $blogService;
    }
    public function index()
    {


          $products = Product::withCount('productComments')->get();
        //  return view('front.404');
        $tagCounts = \App\Models\Product::select('tag', DB::raw('count(*) as total'))
            ->groupBy('tag')
            ->pluck('total', 'tag');
            // return $tagCounts;
        $ProdBlog = array();
        $featuredProducts  = $this->productService->getFeaturedProducts();
        $blogs = $this->blogService->getLatestBlogs();

        $ProdBlog[0] = $featuredProducts;
        $ProdBlog[1] = $blogs;


        $recommendedProducts = [];

        if (auth()->check()) {
            $skin = auth()->user()->skin_type;

            $recommendedProducts = Product::where('skin_type', $skin)
                ->take(3)
                ->get();
        }

        return view('front.index', compact('featuredProducts', "products", 'blogs', 'tagCounts', 'recommendedProducts'));
    }
}
