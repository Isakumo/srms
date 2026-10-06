<?php

namespace App\Services\Rbac;

use App\Models\User;

class RbacService
{
    public function can(User $user, string $permissionCode): bool
    {
        return $user->hasPermission($permissionCode);
    }
}
