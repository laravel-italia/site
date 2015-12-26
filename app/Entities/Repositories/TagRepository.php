<?php

namespace LaravelItalia\Entities\Repositories;

use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Entities\Tag;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

/**
 * Class TagRepository.
 */
class TagRepository
{
    public function getAll()
    {
        return Tag::all();
    }

    public function getBySlugs(array $slugs)
    {
        if (empty($slugs)) {
            return new Collection();
        }

        $tag = Tag::query();

        foreach ($slugs as $slug) {
            $tag->orWhere('slug', $slug);
        }

        return $tag->get();
    }

    public function findById($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            throw new NotFoundException();
        }

        return $tag;
    }

    public function findBySlug($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            throw new NotFoundException();
        }

        return $tag;
    }

    public function save(Tag $tag)
    {
        if (!$tag->save()) {
            throw new NotSavedException();
        }
    }

    public function delete(Tag $tag)
    {
        if (!$tag->delete()) {
            throw new NotDeletedException();
        }
    }
}
