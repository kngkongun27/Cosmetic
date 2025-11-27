<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Repositories\BaseRepositories;

class ProductRepository extends BaseRepositories implements ProductRepositoryInterface {
    public function getModel() 
    {
        return Product::class;
    }

    public function getRelatedProducts ($product, $limit = 4) 
    {
        return $this->model->where('product_category_id', $product->product_category_id)->where('tag', $product->tag)
            ->limit($limit)
            ->get();
    }

    public function getFeaturedProductsByCategory() {
        return $this->model->where('featured', true)->get();
    }

    public function getProductOnIndex($request) {
      
        $search = $request->search ?? '';

        $products = $this->model->where('name', 'like', '%' . $search . '%');

        $products = $this->filter($products, $request);
        $products = $this->sortAndPagination($products, $request);
        return $products;
    }

    public function getProductsByCategory($categoryName, $request) 
    {
            $products = ProductCategory::where('name', $categoryName)->first()->products->toQuery();   
            
            $products = $this->filter($products, $request);
            $products = $this->sortAndPagination($products, $request);


            return $products;
    }

    private function sortAndPagination($products, Request $request) 
    {
        $perPage = $request->input('show', 3);
        $sortBy = $request->sort_by ?? 'latest'; 

        switch($sortBy) {
            case 'latest':
                $products = $products->orderBy('id');
                break;
            case'oldest':
                $products =  $products->orderByDesc('id');
                break;
            case'nameascending':     
                $products =  $products->orderBy('name');
                break;
                case'namedescending':
                $products =  $products->orderByDesc('name');
                break;
                    case'priceascending':
                $products =  $products->orderBy('price');
                break;
                    case'pricedescending':
                $products =  $products->orderByDesc('price');
                default:
                $products =  $products->orderBy('id');
                
        }


        $products = $products->paginate($perPage);

        $products->appends(['sort_by' => $sortBy, 'name' => $perPage]);

        return $products;

    }
    

    private function filter ($products, Request $request) {
            $brands = $request->brand ?? [];
            $brands_ids = array_keys($brands);
            $products = $brands_ids != null ? $products->whereIn('brand_id', $brands_ids) : $products;

            return $products;
    }
}
?>