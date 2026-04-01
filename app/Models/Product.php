<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'unit_price',
        'quantity_in_stock',
        'reorder_level',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'category'  => Category::class,
        'is_active' => 'boolean'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
