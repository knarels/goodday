<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Admin\Article;
use App\Repositories\Admin\ArticleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleRepository $articleRepository)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Articles/Index', [
            'articles' => $this->articleRepository->getAllArticles(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Articles/Create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $this->articleRepository->createArticle($request->validated());

        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
    }

    public function show(Article $article): Response
    {
        $article->load('creator');

        return Inertia::render('Admin/Articles/Show', [
            'article' => $article,
            'canUpdateArticle' => Gate::allows('update', $article),
            'canDeleteArticle' => Gate::allows('delete', $article),
        ]);
    }

    public function edit(Article $article): Response
    {
        Gate::authorize('update', $article);

        return Inertia::render('Admin/Articles/Edit', ['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $this->articleRepository->updateArticle($article, $request->validated());

        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article): RedirectResponse
    {
        Gate::authorize('delete', $article);

        $this->articleRepository->deleteArticle($article);

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }
}
