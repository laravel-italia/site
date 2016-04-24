<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\Article;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Http\Requests\ArticleSaveRequest;
use LaravelItalia\Http\Requests\ArticlePublishRequest;
use LaravelItalia\Domain\Repositories\SeriesRepository;
use LaravelItalia\Domain\Repositories\ArticleRepository;
use LaravelItalia\Domain\Repositories\CategoryRepository;
use LaravelItalia\Domain\Commands\SaveArticleCommand;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
    use DispatchesCommands;

    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:editor,administrator', ['except' => ['postPublish', 'getUnpublish', 'getDelete']]);
        $this->middleware('role:administrator', ['only' => ['postPublish', 'getUnpublish', 'getDelete']]);
    }

    /**
     * @param Request           $request
     * @param ArticleRepository $articleRepository
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getIndex(Request $request, ArticleRepository $articleRepository)
    {
        return view('admin.article_index', [
            'unpublishedArticles' => $articleRepository->getUnpublished(),
            'publishedArticles' => $articleRepository->getAll($request->get('page', 1), true),
        ]);
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @param SeriesRepository   $seriesRepository
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getAdd(CategoryRepository $categoryRepository, SeriesRepository $seriesRepository)
    {
        return view('admin.article_add', [
            'categories' => $categoryRepository->getAll(),
            'series' => $seriesRepository->getAll(),
        ]);
    }

    /**
     * @param ArticleSaveRequest $request
     * @param ArticleRepository  $articleRepository
     * @param SeriesRepository   $seriesRepository
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function postAdd(ArticleSaveRequest $request, ArticleRepository $articleRepository, SeriesRepository $seriesRepository, CategoryRepository $categoryRepository)
    {
        $article = Article::createFromData(
            $request->get('title'),
            $request->get('digest'),
            $request->get('body'),
            $request->get('metadescription')
        );

        $series = ($request->get('series_id') != 0) ? $seriesRepository->findByid($request->get('series_id')) : null;
        $categories = $categoryRepository->getByIds($request->get('categories'));

        try {
            $this->dispatch(new SaveArticleCommand(
                $article,
                Auth::user(),
                $categories,
                $series
            ));

        } catch (NotSavedException $e) {
            return redirect('admin/articles/add')
                ->withInput()
                ->with('error_message', 'Problemi in fase di aggiunta. Riprovare.');
        }

        return redirect('admin/articles')->with('success_message', 'Articolo aggiunto correttamente.');
    }

    /**
     * @param ArticleRepository  $articleRepository
     * @param SeriesRepository   $seriesRepository
     * @param CategoryRepository $categoryRepository
     * @param $articleId
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
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

    /**
     * @param ArticleSaveRequest $request
     * @param ArticleRepository  $articleRepository
     * @param SeriesRepository   $seriesRepository
     * @param CategoryRepository $categoryRepository
     * @param $articleId
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function postEdit(ArticleSaveRequest $request, ArticleRepository $articleRepository, SeriesRepository $seriesRepository, CategoryRepository $categoryRepository, $articleId)
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

        $article->syncCategories($categoryRepository->getByIds($request->get('categories')));

        return redirect('admin/articles/edit/'.$articleId)->with('success_message', 'Articolo modificato correttamente.');
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param $articleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param ArticlePublishRequest $request
     * @param ArticleRepository     $articleRepository
     * @param $articleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param ArticleRepository $articleRepository
     * @param $articleId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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
