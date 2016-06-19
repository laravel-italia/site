<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use LaravelItalia\Domain\Media;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Http\Requests\MediaUploadRequest;
use LaravelItalia\Domain\Repositories\MediaRepository;

/**
 * Class MediaController
 * @package LaravelItalia\Http\Controllers\Admin
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
     * Mostra i media attualmente caricati sul sito.
     *
     * @param MediaRepository $mediaRepository
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(MediaRepository $mediaRepository, Request $request)
    {
        $media = $mediaRepository->getAll($request->get('page', 1));

        return view('admin.media_index', compact('media'));
    }

    /**
     * Salva un nuovo file caricato sul sito.
     *
     * @param MediaUploadRequest $request
     * @param MediaRepository $mediaRepository
     * @return \Illuminate\Http\RedirectResponse
     * @throws \LaravelItalia\Exceptions\NotSavedException
     */
    public function postUpload(MediaUploadRequest $request, MediaRepository $mediaRepository)
    {
        $media = new Media();
        $media->setUser(Auth::user());

        try {
            $mediaRepository->save($media);
        } catch (NotDeletedException $e) {
            return redirect('admin/media')->with('error_message', 'Problemi in fase di salvataggio del media. Riprovare.');
        }

        return redirect('admin/media')->with('success_message', 'Upload effettuato correttamente.');
    }

    /**
     * Cancella un media precedentemente caricato.
     *
     * @param MediaRepository $mediaRepository
     * @param $mediaId
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
