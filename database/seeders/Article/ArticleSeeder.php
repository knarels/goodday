<?php

declare(strict_types=1);

namespace Database\Seeders\Article;

use App\Models\Admin\Article;
use Illuminate\Database\Seeder;

final class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory()->count(10)->create();
    }
}
