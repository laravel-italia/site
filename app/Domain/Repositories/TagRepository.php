<?php

namespace LaravelItalia\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Domain\Tag;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

/**
 * Class TagRepository.
 */
class TagRepository
{
    /**
     * @return Collection|static[]
     */
    public function getAll()
    {
        return Tag::all();
    }

    /**
     * @param array $slugs
     * @return Collection|static[]
     */
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

    /**
     * @param $id
     * @return Tag|null
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            throw new NotFoundException();
        }

        return $tag;
    }

    /**
     * @param $slug
     * @return Tag|null
     * @throws NotFoundException
     */
    public function findBySlug($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            throw new NotFoundException();
        }

        return $tag;
    }

    /**
     * @param Tag $tag
     * @throws NotSavedException
     */
    public function save(Tag $tag)
    {
        if (!$tag->save()) {
            throw new NotSavedException();
        }
    }

    /**
     * @param Tag $tag
     * @throws NotDeletedException
     */
    public function delete(Tag $tag)
    {
        if (!$tag->delete()) {
            throw new NotDeletedException();
        }
    }
}
