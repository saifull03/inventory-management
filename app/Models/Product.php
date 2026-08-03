<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'purchase_date' => 'date',
    ];

    protected $fillable = [
        'product_code',
        'name',
        'brand',
        'model',
        'serial_number',
        'description',
        'warehouse_id',
        'category_id',
        'item_type_id',
        'status',
        'purchase_date',
        'purchase_price',
        'created_by',
        'image_path',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
