<?php

namespace LaravelItalia\Http\Controllers\Admin;

use LaravelItalia\Entities\Repositories\CategoryRepository;
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
}
