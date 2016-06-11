<?php

namespace LaravelItalia\Http\Controllers;

use Illuminate\Http\Request;

use LaravelItalia\Http\Requests;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Domain\Repositories\ArticleRepository;

class FrontController extends Controller
{
    public function getArticle(ArticleRepository $articleRepository, $slug)
    {
        try {
            $article = $articleRepository->findBySlug($slug, true, true);
            return view('front.article', ['article' => $article]);
        } catch (NotFoundException $e) {
            // TODO: implement 404
        }
    }
}
