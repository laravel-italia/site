<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Support\Str;
use LaravelItalia\Entities\Category;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Http\Requests\SaveCategoryRequest;
use LaravelItalia\Entities\Factories\CategoryFactory;
use LaravelItalia\Entities\Repositories\CategoryRepository;

/**
 * Class CategoryController
 * @package LaravelItalia\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getIndex(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getAll();

        return view('admin.category_index', compact('categories'));
    }

    /**
     * @param SaveCategoryRequest $request
     * @param CategoryRepository $categoryRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdd(SaveCategoryRequest $request, CategoryRepository $categoryRepository)
    {
        $category = CategoryFactory::createCategory($request->get('name'));

        try {
            $categoryRepository->save($category);
        } catch (NotSavedException $e) {
            return redirect('admin/categories')->with('error_message', 'Impossibile aggiungere la categoria. Riprovare.');
        }

        return redirect('admin/categories')->with('success_message', 'Categoria aggiunta con successo.');
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @param $categoryId
     * @return Category
     * @throws NotFoundException
     */
    public function getDetails(CategoryRepository $categoryRepository, $categoryId)
    {
        /* @var $category Category */
        $category = $categoryRepository->findById($categoryId);

        return $category;
    }

    /**
     * @param SaveCategoryRequest $request
     * @param CategoryRepository $categoryRepository
     * @param $categoryId
     * @return \Illuminate\Http\RedirectResponse
     * @throws NotSavedException
     */
    public function postEdit(SaveCategoryRequest $request, CategoryRepository $categoryRepository, $categoryId)
    {
        try {
            /* @var $category Category */
            $category = $categoryRepository->findById($categoryId);
        } catch (NotFoundException $e) {
            return redirect('admin/categories')->with('error_message', 'La categoria scelta non esiste o non è più disponibile.');
        }

        $category->name = $request->get('name');
        $category->slug = Str::slug($category->name);

        try {
            $categoryRepository->save($category);
        } catch (NotDeletedException $e) {
            return redirect('admin/categories')->with('error_message', 'Impossibile salvare le modifiche per questa categoria. Riprovare.');
        }

        return redirect('admin/categories')->with('success_message', 'Categoria salvata correttamente.');
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @param $categoryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete(CategoryRepository $categoryRepository, $categoryId)
    {
        try {
            /* @var $category Category */
            $category = $categoryRepository->findById($categoryId);
        } catch (NotFoundException $e) {
            return redirect('admin/categories')->with('error_message', 'La categoria cercata non esiste o non è più disponibile.');
        }

        try {
            $categoryRepository->delete($category);
        } catch (NotDeletedException $e) {
            return redirect('admin/categories')->with('error_message', 'Impossibile elminare la categoria scelta. Riprovare.');
        }

        return redirect('admin/categories')->with('success_message', 'Categoria eliminata correttamente.');
    }
}
