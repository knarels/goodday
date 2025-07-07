<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface RoleAndPermissionRepositoryInterface
{
    /**
     * @return Collection<int, User>
     */
    public function getUsersWithRolesAndPermissions(): Collection;

    /**
     * @return Collection<int, Role>
     */
    public function getAllRolesWithPermissions(): Collection;

    /**
     * @return Collection<int, Permission>
     */
    public function getAllPermissions(): Collection;
}

