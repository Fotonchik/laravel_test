<?php
/* 

1. Получение категорий первого уровня
2. Фильтрация по выбранной категории
3. Сортировка товаров
4. Пагинация результатов
5. Возврат представления с данными

*/

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\PaginationService;

class HomeController extends Controller
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

    public function index(Request $request)
    {
        $selectedCategoryId = $request->get('category_id');
        $sort = $request->get('sort', 'name_asc');
        $perPage = $request->get('per_page', 12);
        
        // Получаем данные категорий
        $categories = $this->categoryService->getTopLevelCategories();
        $selectedCategory = $this->categoryService->getSelectedCategory($selectedCategoryId);
        $subcategories = $selectedCategory 
            ? $this->categoryService->getSubcategoriesWithCounts($selectedCategoryId)
            : collect();
        
        $query = $this->productService->getBaseQuery();
        $query = $this->productService->applyCategoryFilter($query, $selectedCategory);
        $query = $this->productService->applySorting($query, $sort);
        
        // Пагинация
        $products = $this->paginationService->paginate($query, $request, $perPage);
        
        return view('home', compact(
            'products', 
            'categories', 
            'subcategories',
            'selectedCategory',
            'sort', 
            'perPage',
            'selectedCategoryId'
        ));
    }
}