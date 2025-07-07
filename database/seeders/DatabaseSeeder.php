<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Permissions\RolesAndPermissionsSeeder;
use Database\Seeders\Users\UserSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class
        ]);
    }
}
