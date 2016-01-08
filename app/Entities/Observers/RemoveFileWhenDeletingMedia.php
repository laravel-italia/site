<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Media;

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
