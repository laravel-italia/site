<?php

namespace LaravelItalia\Domain\Observers;

use Illuminate\Http\Request;
use LaravelItalia\Domain\Media;

/**
 * Class UploadFileWhenAddingMedia.
 */
class UploadFileWhenAddingMedia
{
    /**
     * @var Request
     */
    private $request;

    /**
     * MediaObserver constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Media $media
     */
    public function creating(Media $media)
    {
        $uploadedFile = $this->request->file('media');
        $fileName = time().$uploadedFile->getClientOriginalName();

        \Storage::put(
            $fileName,
            file_get_contents($uploadedFile->getRealPath())
        );

        $media->url = url('uploads/'.$fileName);
    }
}
