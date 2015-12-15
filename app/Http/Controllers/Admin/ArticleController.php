<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LaravelItalia\Entities\Series;
use LaravelItalia\Entities\Article;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
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
        $this->middleware('role:editor,administrator', ['except' => ['postPublish', 'getUnpublish', 'getDelete']]);
        $this->middleware('role:administrator', ['only' => ['postPublish', 'getUnpublish', 'getDelete']]);
    }

    public function getIndex(Request $request, ArticleRepository $articleRepository)
    {
        return view('admin.article_index', [
            'unpublishedArticles' => $articleRepository->getUnpublished(),
            'publishedArticles' => $articleRepository->getAll($request->get('page', 1), true),
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

        try {
            $articleRepository->save($article);
        } catch (NotSavedException $e) {
            return redirect('admin/articles/add')
                ->withInput()
                ->with('error_message', 'Problemi in fase di aggiunta. Riprovare.');
        }

        $article->categories()->sync($request->get('categories'));

        return redirect('admin/articles')->with('success_message', 'Articolo aggiunto correttamente.');
    }

    public function getEdit(ArticleRepository $articleRepository, SeriesRepository $seriesRepository, CategoryRepository $categoryRepository, $articleId)
    {
        try {
            $article = $articleRepository->findById($articleId);
        } catch (NotFoundException $e) {
            return redirect('admin/articles')->with('error_message', 'L\'articolo scelto non esiste o non è disponibile.');
        }

        $series = $seriesRepository->getAll();
        $categories = $categoryRepository->getAll();

        return view('admin.article_edit', compact('article', 'series', 'categories'));
    }

    public function postEdit(ArticleSaveRequest $request, ArticleRepository $articleRepository, SeriesRepository $seriesRepository, $articleId)
    {
        try {
            /* @var $article Article */
            $article = $articleRepository->findById($articleId);
        } catch (NotFoundException $e) {
            return redirect('admin/articles')->with('error_message', 'L\'articolo scelto non esiste o non è disponibile.');
        }

        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->digest = $request->get('digest');
        $article->metadescription = $request->get('metadescription');

        if ($request->get('series_id') != 0) {

            /* @var $series Series */
            $series = $seriesRepository->findByid($request->get('series_id'));
            $article->setSeries($series);
        }

        try {
            $articleRepository->save($article);
        } catch (NotSavedException $e) {
            return redirect('admin/articles/edit/'.$articleId)
                ->withInput()
                ->with('error_message', 'Problemi in fase di modifica. Riprovare.');
        }

        $article->categories()->sync($request->get('categories'));

        return redirect('admin/articles/edit/'.$articleId)->with('success_message', 'Articolo modificato correttamente.');
    }

    public function getUnpublish(ArticleRepository $articleRepository, $articleId)
    {
        try {
            /* @var $article Article */
            $article = $articleRepository->findById($articleId);
        } catch (NotFoundException $e) {
            return redirect('admin/articles')->with('error_message', 'L\'articolo scelto non esiste o non è disponibile.');
        }

        $article->unpublish();

        try {
            $articleRepository->save($article);
        } catch (NotSavedException $e) {
            return redirect('admin/articles')
                ->with('error_message', 'Problemi durante la rimozione dalla pubblicazione. Riprovare.');
        }

        return redirect('admin/articles')->with('success_message', 'Articolo rimosso dalla pubblicazione correttamente.');
    }

    public function postPublish(ArticlePublishRequest $request, ArticleRepository $articleRepository, $articleId)
    {
        try {
            /* @var $article Article */
            $article = $articleRepository->findById($articleId);
        } catch (NotFoundException $e) {
            return redirect('admin/articles')->with('error_message', 'L\'articolo scelto non esiste o non è disponibile.');
        }

        $publicationDate = Carbon::createFromFormat('d/m/Y H:i', $request->get('published_at'));
        $article->publish($publicationDate);

        try {
            $articleRepository->save($article);
        } catch (NotSavedException $e) {
            return redirect('admin/articles')
                ->with('error_message', 'Problemi durante la pubblicazione. Riprovare.');
        }

        return redirect('admin/articles')->with('success_message', 'Articolo mandato in pubblicazione correttamente.');
    }

    public function getDelete(ArticleRepository $articleRepository, $articleId)
    {
        try {
            /* @var $article Article */
            $article = $articleRepository->findById($articleId);
        } catch (NotFoundException $e) {
            return redirect('admin/articles')->with('error_message', 'L\'articolo scelto non esiste o non è disponibile.');
        }

        try {
            $articleRepository->delete($article);
        } catch (NotDeletedException $e) {
            return redirect('admin/articles')->with('error_message', 'Impossibile cancellare l\'articolo selezionato.');
        }

        return redirect('admin/articles')->with('success_message', 'Articolo cancellato correttamente.');
    }
}
