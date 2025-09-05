<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['name', 'id_parent'];

    public function children()
    {
        return $this->hasMany(Group::class, 'id_parent', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Group::class, 'id_parent', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_group', 'id');
    }

    public function getAllDescendantIds()
    {
        $ids = [$this->id];
        
        $children = Group::where('id_parent', $this->id)->with('children')->get();
        
        foreach ($children as $child) {
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }
        
        return $ids;
    }

    public function getTotalProductsCount()
    {
        $categoryIds = $this->getAllDescendantIds();
        return Product::whereIn('id_group', $categoryIds)->count();
    }

    public function scopeTopLevel($query)
    {
        return $query->where('id_parent', 0);
    }

    // Метод для получения подкатегорий с количеством товаров
    public function getSubcategoriesWithCounts()
    {
        return $this->children()->withCount(['products'])->get()->map(function($subcategory) {
            $subcategory->total_products_count = $subcategory->getTotalProductsCount();
            return $subcategory;
        });
    }
}