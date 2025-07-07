<?php

declare(strict_types=1);

namespace Database\Seeders\Users;

use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->user()->count(5)->create();

        // Creating Admin User. This should not be here and is added for the simplicity.
        User::factory()->admin()->createOne();
    }
}
