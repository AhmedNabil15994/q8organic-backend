<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Repositories\FrontEnd\BrandRepository as Brand;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;

class SearchController extends Controller
{

    function __construct(Product $product,Category $category,Brand $brand)
    {
        $this->product  = $product;
        $this->category = $category;
        $this->brand    = $brand;
    }

    public function index(Request $request)
    {
        $data =  $this->product->searchProducts($request['search']);

        return view('catalog::frontend.search.index',compact('request'));
    }
}
