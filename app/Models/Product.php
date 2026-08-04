<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_code) || $product->product_code === '[Auto-generated]') {
                $itemType = ItemType::findOrFail($product->item_type_id);
                $prefix = $itemType->prefix;

                $latestProduct = Product::where('item_type_id', $product->item_type_id)
                    ->latest('id')
                    ->value('product_code');

                $nextNumber = 1;
                if ($latestProduct && \Illuminate\Support\Str::startsWith($latestProduct, $prefix)) {
                    $lastNumber = (int) \Illuminate\Support\Str::substr($latestProduct, strlen($prefix));
                    $nextNumber = $lastNumber + 1;
                }

                $product->product_code = $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });

        static::saving(function ($product) {
            if (!empty($product->employee_id)) {
                $product->status = 'Assigned';
            } elseif ($product->status === 'Assigned') {
                $product->status = 'Available';
            }
        });
    }

    protected $casts = [
        'purchase_date' => 'date',
        'custom_fields' => 'array',
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
        'employee_id',
        'custom_fields',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
