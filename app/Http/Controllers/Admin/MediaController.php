<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use LaravelItalia\Entities\Factories\MediaFactory;
use LaravelItalia\Entities\Media;
use LaravelItalia\Entities\Repositories\MediaRepository;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Http\Requests\MediaUploadRequest;
use LaravelItalia\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:editor,administrator');
    }

    public function getIndex(MediaRepository $mediaRepository, Request $request)
    {
        $media = $mediaRepository->getAll($request->get('page', 1));

        return view('admin.media_index', compact('media'));
    }

    public function postUpload(MediaUploadRequest $request, MediaRepository $mediaRepository)
    {
        $media = MediaFactory::createMedia();
        $media->setUser(Auth::user());

        try {
            $mediaRepository->save($media);
        } catch (NotDeletedException $e) {
            return redirect('admin/media')->with('error_message', 'Problemi in fase di salvataggio del media. Riprovare.');
        }

        return redirect('admin/media')->with('success_message', 'Upload effettuato correttamente.');
    }

    public function getDelete(MediaRepository $mediaRepository, $mediaId)
    {
        try {
            /* @var $media Media */
            $media = $mediaRepository->findById($mediaId);
        } catch (NotFoundException $e) {
            return redirect('admin/media')->with('error_message', 'Il media selezionato è stato già rimosso.');
        }

        try {
            $mediaRepository->delete($media);
        } catch (NotDeletedException $e) {
            return redirect('admin/media')->with('error_message', 'Problemi in fase di rimozione del media. Riprovare.');
        }

        return redirect('admin/media')->with('success_message', 'Media eliminato correttamente.');
    }
}
