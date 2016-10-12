<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Template;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

class TemplateRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Template::all();
    }

    /**
     * Restituisce un template dato il suo id.
     *
     * @param $id
     * @return mixed
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $template = Template::find($id);

        if (!$template) {
            throw new NotFoundException();
        }

        return $template;
    }

    /**
     * Salva un nuovo template $template su database.
     *
     * @param Template $template
     * @throws NotSavedException
     */
    public function save(Template $template)
    {
        if (!$template->save()) {
            throw new NotSavedException();
        }
    }

    /**
     * Cancella il template $template dal database.
     *
     * @param Template $template
     * @throws NotDeletedException
     * @throws \Exception
     */
    public function delete(Template $template)
    {
        if (!$template->delete()) {
            throw new NotDeletedException();
        }
    }
}
