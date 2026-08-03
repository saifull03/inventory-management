<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;

class InventoryPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, $model): bool
    {
        return true;
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(?User $user, $model): bool
    {
        return true;
    }

    public function delete(?User $user, $model): bool
    {
        return true;
    }

    public function restore(?User $user, $model): bool
    {
        return true;
    }

    public function forceDelete(?User $user, $model): bool
    {
        return true;
    }
}
