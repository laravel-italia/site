<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LaravelItalia\Entities\Series;
use LaravelItalia\Entities\Article;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Http\Requests\ArticleSaveRequest;
use LaravelItalia\Entities\Factories\ArticleFactory;
use LaravelItalia\Entities\Repositories\SeriesRepository;
use LaravelItalia\Entities\Repositories\ArticleRepository;
use LaravelItalia\Entities\Repositories\CategoryRepository;
use LaravelItalia\Http\Requests\ArticlePublishRequest;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator', ['only' => ['postPublish', 'getUnpublish']]);
    }

    public function getIndex(Request $request, ArticleRepository $articleRepository)
    {
        return view('admin.article_index', [
            'articles' => $articleRepository->getAll($request->get('page', 1)),
        ]);
    }

    public function getAdd(CategoryRepository $categoryRepository, SeriesRepository $seriesRepository)
    {
        return view('admin.article_add', [
            'categories' => $categoryRepository->getAll(),
            'series' => $seriesRepository->getAll(),
        ]);
    }

    public function postAdd(ArticleSaveRequest $request, ArticleRepository $articleRepository, SeriesRepository $seriesRepository)
    {
        $article = ArticleFactory::createArticle(
            $request->get('title'),
            $request->get('digest'),
            $request->get('body'),
            $request->get('metadescription')
        );

        if ($request->get('series_id') != 0) {

            /* @var $series Series */
            $series = $seriesRepository->findByid($request->get('series_id'));
            $article->setSeries($series);
        }

        $article->setUser(Auth::user());

        $articleRepository->save($article);

        $article->categories()->sync($request->get('categories'));

        return redirect('admin/articles')->withInput()->with('success_message', 'Articolo aggiunto correttamente.');
    }

    public function getUnpublish(ArticleRepository $articleRepository, $articleId)
    {
        /* @var $article Article */
        $article = $articleRepository->findById($articleId);

        $article->unpublish();
        $articleRepository->save($article);

        return redirect('admin/articles')->with('success_message', 'Articolo rimosso dalla pubblicazione correttamente.');
    }

    public function postPublish(ArticlePublishRequest $request, ArticleRepository $articleRepository, $articleId)
    {
        /* @var $article Article */
        $article = $articleRepository->findById($articleId);

        $publicationDate = Carbon::createFromFormat('d/m/Y H:i', $request->get('published_at'));
        $article->publish($publicationDate);

        $articleRepository->save($article);

        return redirect('admin/articles')->with('success_message', 'Articolo mandato in pubblicazione correttamente.');
    }

    public function getDelete(ArticleRepository $articleRepository, $articleId)
    {
        /* @var $article Article */
        $article = $articleRepository->findById($articleId);
        $articleRepository->delete($article);

        return redirect('admin/articles')->with('success_message', 'Articolo cancellato correttamente.');
    }
}
