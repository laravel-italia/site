<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Support\Str;
use LaravelItalia\Entities\Factories\TagFactory;
use LaravelItalia\Entities\Repositories\TagRepository;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Entities\Tag;
use LaravelItalia\Http\Requests\TagSaveRequest;

class TagController extends Controller
{
    public function getIndex(TagRepository $tagRepository)
    {
        $tags = $tagRepository->getAll();

        return view('admin.tag_index', compact('tags'));
    }

    public function postAdd(TagSaveRequest $request, TagRepository $tagRepository)
    {
        $tag = TagFactory::createTag($request->get('name'));

        try {
            $tagRepository->save($tag);
        } catch (NotSavedException $e) {
            return redirect('admin/tags')->with('error_message', 'Problemi in fase di aggiunta del tag. Riprovare.');
        }

        return redirect('admin/tags')->with('success_message', 'Tag aggiunto correttamente.');
    }

    public function getDetails(TagRepository $tagRepository, $tagId)
    {
        /* @var $tag Tag */
        $tag = $tagRepository->findById($tagId);

        return $tag;
    }

    public function postEdit(TagSaveRequest $request, TagRepository $tagRepository, $tagId)
    {
        try {
            /* @var $tag Tag */
            $tag = $tagRepository->findById($tagId);
        } catch (NotFoundException $e) {
            return redirect('admin/tags')->with('error_message', 'Il tag scelto non esiste o è stato già rimosso!');
        }

        $tag->name = $request->get('name');
        $tag->slug = Str::slug($tag->name);

        try {
            $tagRepository->save($tag);
        } catch (NotDeletedException $e) {
            return redirect('admin/tags')->with('error_message', 'Impossibile salvare le modifiche per questo tag. Riprovare.');
        }

        return redirect('admin/tags')->with('success_message', 'Tag salvato correttamente.');
    }

    public function getDelete(TagRepository $tagRepository, $tagId)
    {
        try {
            $tag = $tagRepository->findById($tagId);
        } catch (NotFoundException $e) {
            return redirect('admin/tags')->with('error_message', 'Errore in fase di cancellazione. Il tag scelto è stato già rimosso!');
        }

        try {
            $tagRepository->delete($tag);
        } catch (NotDeletedException $e) {
            return redirect('admin/tags')->with('error_message', 'Errore in fase di cancellazione. Riprovare!');
        }

        return redirect('admin/tags')->with('success_message', 'Tag rimosso correttamente.');
    }
}
