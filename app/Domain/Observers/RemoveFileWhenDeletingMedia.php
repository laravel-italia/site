<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Media;

/**
 * Class RemoveFileWhenDeletingMedia.
 */
class RemoveFileWhenDeletingMedia
{
    /**
     * @param Media $media
     */
    public function deleting(Media $media)
    {
        $fileName = str_replace(url('uploads/'), '', $media->url);
        \Storage::delete($fileName);
    }
}
