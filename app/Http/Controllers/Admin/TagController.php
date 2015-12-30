<?php

namespace LaravelItalia\Http\Controllers\Admin;

use LaravelItalia\Entities\Repositories\TagRepository;
use LaravelItalia\Http\Controllers\Controller;

class TagController extends Controller
{
    public function getIndex(TagRepository $tagRepository)
    {
        $tags = $tagRepository->getAll();

        return view('admin.tag_index', compact('tags'));
    }
}
