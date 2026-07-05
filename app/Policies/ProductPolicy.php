<?php

namespace App\Policies;

use App\Models\Usuario;

class ProductPolicy
{
    public function viewAny(?Usuario $usuario): bool { return true; } // catálogo é público
    public function create(Usuario $usuario): bool    { return $usuario->isAdmin(); }
    public function update(Usuario $usuario): bool    { return $usuario->isAdmin(); }
}
