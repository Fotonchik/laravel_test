<?php

namespace App\Services;

use App\Models\Group;

class CategoryService
{
    public function getTopLevelCategories()
    {
        $categories = Group::topLevel()->get();
        foreach ($categories as $category) {
            $category->total_products_count = $category->getTotalProductsCount();
        }
        
        return $categories;
    }

    public function getSubcategoriesWithCounts($categoryId)
    {
        $category = Group::find($categoryId);
        if (!$category) {
            return collect();
        }
        
        return $category->getSubcategoriesWithCounts();
    }

    public function getSelectedCategory($categoryId)
    {
        return $categoryId ? Group::find($categoryId) : null;
    }
}