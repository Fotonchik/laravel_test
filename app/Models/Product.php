<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['name', 'id_group'];

    // Отношения
    public function prices()
    {
        return $this->hasMany(Price::class, 'id_product', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id');
    }

    public function getCurrentPrice()
    {
        return $this->prices->first()->price ?? 0;
    }
}