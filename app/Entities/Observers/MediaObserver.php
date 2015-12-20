<?php

namespace LaravelItalia\Entities\Observers;

use Illuminate\Http\Request;
use LaravelItalia\Entities\Media;

class MediaObserver
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

    public function deleting(Media $media)
    {
        $fileName = str_replace(url('uploads/'), '', $media->url);
        \Storage::delete($fileName);
    }
}
