<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'name',
        'prefix',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
