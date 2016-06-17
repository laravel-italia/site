<?php

namespace LaravelItalia\Http\Controllers;

use Illuminate\Http\Request;

use LaravelItalia\Domain\Repositories\CategoryRepository;
use LaravelItalia\Domain\Repositories\SeriesRepository;
use LaravelItalia\Http\Requests;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Domain\Repositories\ArticleRepository;

class FrontController extends Controller
{
    public function getIndex(ArticleRepository $articleRepository)
    {
        $latestArticles = $articleRepository->getAll(1, true, true);
        return view('front.index', compact('latestArticles'));
    }

    public function getArticles(ArticleRepository $articleRepository, CategoryRepository $categoryRepository, Request $request) {
        $categories = $categoryRepository->getAll();

        if($request->has('categoria')) {
            $category = $categoryRepository->findBySlug($request->get('categoria'));
            $articles = $articleRepository->getByCategory($category, $request->get('page', 1), true, true);
        } else {
            $articles = $articleRepository->getAll($request->get('page', 1), true, true);
        }

        return view('front.articles', compact('articles', 'categories'));
    }

    public function getArticle(ArticleRepository $articleRepository, $slug)
    {
        try {
            $article = $articleRepository->findBySlug($slug, true, true);
            return view('front.article', ['article' => $article]);
        } catch (NotFoundException $e) {
            return view('front.404');
        }
    }

    public function getSeries(SeriesRepository $seriesRepository)
    {
        try {
            $series = $seriesRepository->getAll(true);
            return view('front.series', compact('series'));
        } catch (NotFoundException $e) {
            return view('front.404');
        }
    }

    public function getSeriesFirstArticle(SeriesRepository $seriesRepository, $slug)
    {
        try {
            $series = $seriesRepository->findBySlug($slug, true);
            $firstArticle = $series->articles->first();
            return redirect('articoli/' . $firstArticle->slug);
        } catch (NotFoundException $e) {
            return view('front.404');
        }
    }
}
