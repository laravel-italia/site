<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;

use LaravelItalia\Entities\Repositories\ArticleRepository;
use LaravelItalia\Entities\Repositories\CategoryRepository;
use LaravelItalia\Entities\Repositories\SeriesRepository;
use LaravelItalia\Http\Requests;
use LaravelItalia\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function getIndex(Request $request, ArticleRepository $articleRepository)
    {
        return view('admin.articles_index', [
            'articles' => $articleRepository->getAll($request->get('page', 1))
        ]);
    }

    public function getAdd(CategoryRepository $categoryRepository, SeriesRepository $seriesRepository)
    {
        return view('admin.articles_add', [
            'categories' => $categoryRepository->getAll(),
            'series' => $seriesRepository->getAll()
        ]);
    }

    public function postAdd()
    {

    }

    public function getEdit($articleId)
    {

    }

    public function postEdit($articleId)
    {

    }

    public function getPublish($articleId)
    {

    }

    public function getUnpublish($articleId)
    {

    }
}
