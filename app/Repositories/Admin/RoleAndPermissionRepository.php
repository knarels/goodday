<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionRepository
{
    /**
     * @return Collection<int, User>
     */
    public function getUsersWithRolesAndPermissions(): Collection
    {
        return User::with('roles:id,name', 'permissions:id,name')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Collection<int, Role>
     */
    public function getAllRolesWithPermissions(): Collection
    {
        return Role::with('permissions:id,name')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Collection<int, Permission>
     */
    public function getAllPermissions(): Collection
    {
        return Permission::orderBy('name')->get(['id', 'name']);
    }
}
