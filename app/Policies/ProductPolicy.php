<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    public function viewAny(?User $user): bool { return true; } // catálogo é público
    public function create(User $user): bool    { return $user->isAdmin(); }
    public function update(User $user): bool    { return $user->isAdmin(); }
}
