<?php

namespace LaravelItalia\Http\Controllers;

use Illuminate\Http\Request;

use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Series;
use LaravelItalia\Http\Requests;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Domain\Repositories\SeriesRepository;
use LaravelItalia\Domain\Repositories\ArticleRepository;
use LaravelItalia\Domain\Repositories\CategoryRepository;

/**
 * Class FrontController
 * @package LaravelItalia\Http\Controllers
 */
class FrontController extends Controller
{
    /**
     * Mostra la pagina principale del sito.
     *
     * @param ArticleRepository $articleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ArticleRepository $articleRepository)
    {
        $latestArticles = $articleRepository->getAll(1, true, true);
        return view('front.index', compact('latestArticles'));
    }

    /**
     * Mostra la raccolta degli articoli. Se viene specificata una categoria, vengono mostrati solo gli articoli
     * della categoria specificata.
     *
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws NotFoundException
     */
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

    /**
     * Mostra un articolo, partendo dal suo slug.
     *
     * @param ArticleRepository $articleRepository
     * @param $slug
     * @param $slug2
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getArticle(ArticleRepository $articleRepository, SeriesRepository $seriesRepository, $slug, $slug2 = null)
    {
        if($slug2) {
            try {
                /* @var Series $series */
                $series = $seriesRepository->findBySlug($slug, true);

                /* @var Article $article */
                $article = $articleRepository->findBySeriesAndSlug($series, $slug2);

                return view('front.article', compact('article'));
            } catch (NotFoundException $e) {
                return view('front.404');
            }
        }

        try {
            $article = $articleRepository->findBySlug($slug, true, true);
            return view('front.article', compact('article'));
        } catch (NotFoundException $e) {
            return view('front.404');
        }
    }

    /**
     * Mostra l'elenco delle serie pubblicate sul sito.
     *
     * @param SeriesRepository $seriesRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeries(SeriesRepository $seriesRepository)
    {
        try {
            $series = $seriesRepository->getAll(true);
            return view('front.series', compact('series'));
        } catch (NotFoundException $e) {
            return view('front.404');
        }
    }

    /**
     * Partendo dallo slug di una serie, redireziona il lettore al primo articolo, pubblicato, della serie.
     *
     * @param SeriesRepository $seriesRepository
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getSeriesFirstArticle(SeriesRepository $seriesRepository, $slug)
    {
        try {
            $series = $seriesRepository->findBySlug($slug, true);
            $firstArticle = $series->articles->first();
            return redirect('articoli/' . $series->slug . '/' . $firstArticle->slug);
        } catch (NotFoundException $e) {
            return view('front.404');
        }
    }


    /**
     * Mostra la privacy policy del sito.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPrivacyPolicy()
    {
        return view('front.privacy');
    }
}
