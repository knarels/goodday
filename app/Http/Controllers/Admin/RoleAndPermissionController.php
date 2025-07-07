<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRolePermissionsRequest;
use App\Http\Requests\Admin\UpdateUserRolesRequest;
use App\Http\Resources\Admin\PermissionResource;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Repositories\RoleAndPermissionRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    public function __construct(private readonly RoleAndPermissionRepositoryInterface $roleAndPermissionRepository)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Admin/RolesAndPermissions', [
            'users' => UserResource::collection($this->roleAndPermissionRepository->getUsersWithRolesAndPermissions()),
            'roles' => RoleResource::collection($this->roleAndPermissionRepository->getAllRolesWithPermissions()),
            'permissions' => PermissionResource::collection($this->roleAndPermissionRepository->getAllPermissions()),
        ]);
    }

    /**
     * @param UpdateUserRolesRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateUserRoles(UpdateUserRolesRequest $request, User $user): RedirectResponse
    {
        $user->syncRoles($request->input('roles', []));

        return back()->with('success', 'User roles updated successfully.');
    }

    /**
     * @param UpdateRolePermissionsRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function updateRolePermissions(UpdateRolePermissionsRequest $request, Role $role): RedirectResponse
    {
        $role->syncPermissions($request->input('permissions', []));

        return back()->with('success', 'Role permissions updated successfully.');
    }
}
