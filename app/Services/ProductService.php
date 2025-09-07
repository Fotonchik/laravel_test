<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    /**
     * Сортировка
     */
    public function applySorting(Builder $query, string $sort): Builder
    {
        switch ($sort) {
            case 'price_asc':
                return $query->join('prices', 'products.id', '=', 'prices.id_product')
                           ->orderBy('prices.price', 'asc')
                           ->select('products.*', 'prices.price');
            
            case 'price_desc':
                return $query->join('prices', 'products.id', '=', 'prices.id_product')
                           ->orderBy('prices.price', 'desc')
                           ->select('products.*', 'prices.price');
            
            case 'name_desc':
                return $query->orderBy('name', 'desc');
            
            default: // name_asc
                return $query->orderBy('name', 'asc');
        }
    }

    public function getBaseQuery(): Builder
    {
        return Product::with(['prices', 'group']);
    }

    /**
     * Фильтр
     */
    public function applyCategoryFilter(Builder $query, $category): Builder
    {
        if ($category) {
            $categoryIds = $category->getAllDescendantIds();
            $query->whereIn('id_group', $categoryIds);
        }
        
        return $query;
    }

    public function getCategoryChain($product)
    {
        $categoryChain = [];
        $currentCategory = $product->group;
        
        while ($currentCategory) {
            $categoryChain[] = $currentCategory;
            $currentCategory = $currentCategory->parent;
        }
        
        return array_reverse($categoryChain);
    }
}