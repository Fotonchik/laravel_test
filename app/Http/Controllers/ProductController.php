<?php
/* 

1. Получение товара с ценами и категорией
2. Построение цепочки категорий
3. Отображение карточки товара

*/
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name_asc');
        
        $query = $this->productService->getBaseQuery();
        $query = $this->productService->applySorting($query, $sort);
        
        $products = $query->paginate(12);
        $categories = $this->categoryService->getTopLevelCategories();
        
        return view('welcome', compact('products', 'categories', 'sort'));
    }
    
    public function show($id)
    {
        $product = Product::with(['prices', 'group'])->findOrFail($id);
        $categoryChain = $this->productService->getCategoryChain($product);
        
        return view('product.show', compact('product', 'categoryChain'));
    }
}