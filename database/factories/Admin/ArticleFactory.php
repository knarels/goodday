<?php

declare(strict_types=1);

namespace Database\Factories\Admin;

use App\Models\Admin\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

class ArticleFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Article::class;

    /**
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['blog', 'news']),
            'title' => $this->faker->sentence(random_int(3, 7)),
            'short_description' => $this->faker->sentence(random_int(10, 20)),
            'text' => $this->faker->paragraphs(random_int(3, 7), true),
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }
}
