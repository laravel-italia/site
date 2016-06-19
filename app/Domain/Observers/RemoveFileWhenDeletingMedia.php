<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Media;

/**
 * Si occupa di rimuovere fisicamente un file quando viene richiesta la cancellazione del media corrispondente.
 *
 * Class RemoveFileWhenDeletingMedia
 * @package LaravelItalia\Domain\Observers
 */
class RemoveFileWhenDeletingMedia
{
    public function deleting(Media $media)
    {
        $fileName = str_replace(url('uploads/'), '', $media->url);
        \Storage::delete($fileName);
    }
}
