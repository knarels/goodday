<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    private const PERMISSION_VIEW_NEWS = 'view news';
    private const PERMISSION_MANAGE_NEWS = 'manage news';
    private const PERMISSION_VIEW_BLOG = 'view blog';
    private const PERMISSION_MANAGE_BLOG = 'manage blog';
    private const PERMISSIONS = [
        self::PERMISSION_VIEW_NEWS,
        self::PERMISSION_MANAGE_NEWS,
        self::PERMISSION_VIEW_BLOG,
        self::PERMISSION_MANAGE_BLOG
    ];

    private const ROLE_ADMIN = 'admin';
    private const ROLE_USER = 'user';
    private const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_USER
    ];

    private const ROLE_PERMISSIONS = [
        self::ROLE_USER => [self::PERMISSION_VIEW_NEWS, self::PERMISSION_VIEW_BLOG]
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
        array_map(function (string $permissionName) {
            Permission::findOrCreate($permissionName);
        }, self::PERMISSIONS);
    }

    private function createRoles(): void
    {
        array_map(function (string $roleName) {
            Role::findOrCreate($roleName);
        }, self::ROLES);
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
