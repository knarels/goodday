<?php

declare(strict_types=1);

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RolesAndPermissionsSeeder extends Seeder
{
    private const MANAGE_ROLES               = 'manage roles';
    private const MANAGE_PERMISSIONS         = 'manage permissions';
    private const MANAGE_USERS               = 'manage users';
    private const PERMISSION_VIEW_ARTICLES   = 'view articles';
    private const PERMISSION_MANAGE_ARTICLES = 'manage articles';
    private const PERMISSIONS = [
        self::MANAGE_ROLES,
        self::MANAGE_PERMISSIONS,
        self::MANAGE_USERS,
        self::PERMISSION_VIEW_ARTICLES,
        self::PERMISSION_MANAGE_ARTICLES
    ];

    private const ROLE_ADMIN = 'admin';
    private const ROLE_USER = 'user';
    private const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_USER
    ];

    private const ROLE_PERMISSIONS = [
        self::ROLE_USER => [self::PERMISSION_VIEW_ARTICLES]
    ];

    public function __construct(private readonly PermissionRegistrar $permissionRegistrar)
    {
    }

    public function run(): void
    {
        $this->permissionRegistrar->forgetCachedPermissions();

        $this->createPermissions();
        $this->createRoles();
        $this->assignPermissionsToRoles();
    }

    private function createPermissions(): void
    {
        array_map(static fn(string $permissionName) => Permission::findOrCreate($permissionName), self::PERMISSIONS);
    }

    private function createRoles(): void
    {
        array_map(static fn(string $roleName) => Role::findOrCreate($roleName), self::ROLES);
    }

    private function assignPermissionsToRoles(): void
    {
        $roleAdmin = Role::findByName(self::ROLE_ADMIN);
        $roleAdmin->givePermissionTo(Permission::all());

        foreach (self::ROLE_PERMISSIONS as $roleName => $permissions) {
            $role = Role::findByName($roleName);
            $role->givePermissionTo($permissions);
        }
    }
}
