<?php

namespace LaravelItalia\Http\Controllers\Admin;

use LaravelItalia\Entities\Category;
use LaravelItalia\Entities\Factories\CategoryFactory;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Requests\SaveCategoryRequest;
use LaravelItalia\Entities\Repositories\CategoryRepository;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator');
    }

    public function getIndex(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getAll();

        return view('admin.category_index', compact('categories'));
    }

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
