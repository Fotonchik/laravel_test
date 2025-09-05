<?php
/* 

1. Получение категории и её подкатегорий
2. Рекурсивный поиск всех товаров в дереве категорий
3. Сортировка и пагинация
4. Формирование хлебных крошек

*/
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\PaginationService;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $productService;
    protected $paginationService;

    public function __construct(
        CategoryService $categoryService,
        ProductService $productService,
        PaginationService $paginationService
    ) {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->paginationService = $paginationService;
    }
    
    public function show($id, Request $request)
    {
        $category = $this->getCategory($id);
        $sort = $this->getSortParameter($request);
        $perPage = $this->getPerPageParameter($request);
        
        $products = $this->getProductsForCategory($category, $sort, $perPage, $request);
        $viewData = $this->prepareViewData($category, $products, $sort, $perPage);
        
        return view('category.show', $viewData);
    }

    
    // Получить категорию по ID
    
    private function getCategory($id)
    {
        return Group::findOrFail($id);
    }

    private function getSortParameter(Request $request)
    {
        return $request->get('sort', 'name_asc');
    }

    private function getPerPageParameter(Request $request)
    {
        return $request->get('per_page', 12);
    }

    private function getProductsForCategory($category, $sort, $perPage, Request $request)
    {
        $query = $this->productService->getBaseQuery()
                    ->whereIn('id_group', $category->getAllDescendantIds());
        
        $query = $this->productService->applySorting($query, $sort);
        
        return $this->paginationService->paginate($query, $request, $perPage);
    }

    private function prepareViewData($category, $products, $sort, $perPage)
    {
        $subcategories = $category->getSubcategoriesWithCounts();
        $topLevelCategories = $this->categoryService->getTopLevelCategories();
        
        return compact(
            'category', 
            'products', 
            'subcategories',
            'topLevelCategories',
            'sort', 
            'perPage'
        );
    }
}