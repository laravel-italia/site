<?php

namespace LaravelItalia\Http\Controllers;

use Illuminate\Http\Request;

use LaravelItalia\Domain\Repositories\ArticleRepository;
use LaravelItalia\Http\Requests;
use LaravelItalia\Http\Controllers\Controller;

class FrontController extends Controller
{
    public function getArticle(ArticleRepository $articleRepository, $slug)
    {
        $article = $articleRepository->findBySlug($slug);
        return view('front.article', ['article' => $article]);
    }
}
