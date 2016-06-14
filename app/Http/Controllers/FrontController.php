<?php

namespace LaravelItalia\Http\Controllers;

use Illuminate\Http\Request;

use LaravelItalia\Domain\Repositories\SeriesRepository;
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
