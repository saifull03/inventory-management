<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'code',
        'name',
        'location',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($warehouse) {
            if (empty($warehouse->code) || $warehouse->code === '[Auto-generated]') {
                $latestWarehouse = Warehouse::where('code', 'like', 'WH-%')
                    ->latest('id')
                    ->value('code');

                $nextNumber = 1;
                if ($latestWarehouse) {
                    preg_match('/\d+$/', $latestWarehouse, $matches);
                    if (!empty($matches)) {
                        $lastNumber = (int) $matches[0];
                        $nextNumber = $lastNumber + 1;
                    }
                }

                $warehouse->code = 'WH-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}