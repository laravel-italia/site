<?php

namespace LaravelItalia\Domain\Observers;

use Illuminate\Http\Request;
use LaravelItalia\Domain\Media;

/**
 * Si occupa di gestire il caricamento e salvataggio di un file durante l'upload di un nuovo media.
 *
 * Class UploadFileWhenAddingMedia
 * @package LaravelItalia\Domain\Observers
 */
class UploadFileWhenAddingMedia
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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
