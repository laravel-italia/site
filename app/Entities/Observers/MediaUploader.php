<?php

namespace LaravelItalia\Entities\Observers;

use Illuminate\Http\Request;
use LaravelItalia\Entities\Media;

class MediaUploader
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function creating(Media $media)
    {
        $uploadedFile = $this->request->file('media');
        $fileName = time().$uploadedFile->getClientOriginalName().$uploadedFile->getClientOriginalExtension();

        \Storage::put(
            $fileName,
            $this->getFileContents($uploadedFile->getRealPath())
        );

        $media->setUrl($fileName);
    }

    private function getFileContents($realPath)
    {
        return file_get_contents($realPath);
    }
}
