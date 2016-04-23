<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use LaravelItalia\Domain\Media;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Domain\Factories\MediaFactory;
use LaravelItalia\Http\Requests\MediaUploadRequest;
use LaravelItalia\Domain\Repositories\MediaRepository;

/**
 * Class MediaController.
 */
class MediaController extends Controller
{
    /**
     * MediaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:editor,administrator');
    }

    /**
     * @param MediaRepository $mediaRepository
     * @param Request         $request
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getIndex(MediaRepository $mediaRepository, Request $request)
    {
        $media = $mediaRepository->getAll($request->get('page', 1));

        return view('admin.media_index', compact('media'));
    }

    /**
     * @param MediaUploadRequest $request
     * @param MediaRepository    $mediaRepository
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \LaravelItalia\Exceptions\NotSavedException
     */
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

    /**
     * @param MediaRepository $mediaRepository
     * @param $mediaId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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
