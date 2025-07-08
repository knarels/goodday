<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Admin\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function getAllArticles(): Collection
    {
        return Article::orderBy('created_at', 'desc')->get();
    }

    public function createArticle(array $data): Article
    {
        return Article::create($data);
    }

    public function updateArticle(Article $article, array $data): bool
    {
        return $article->update($data);
    }

    public function deleteArticle(Article $article): ?bool
    {
        return $article->delete();
    }
}
