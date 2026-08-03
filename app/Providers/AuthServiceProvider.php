<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\Warehouse;
use App\Policies\InventoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class => InventoryPolicy::class,
        ItemType::class => InventoryPolicy::class,
        Product::class => InventoryPolicy::class,
        Warehouse::class => InventoryPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
