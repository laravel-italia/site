<?php

namespace LaravelItalia\Http\Controllers;

use Auth;
use LaravelItalia\Domain\MapEntry;
use LaravelItalia\Domain\Repositories\MapEntryRepository;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Requests\MapEntryAddRequest;

/**
 * Class MapController
 * @package LaravelItalia\Http\Controllers
 */
class MapController extends Controller
{
    /**
     * MapController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.front', ['only' => 'getAddEntry', 'postAddEntry']);
    }

    /**
     * Mostra il form di aggiunta di una nuova entry.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddEntry()
    {
        return view('front.map_add');
    }

    /**
     * Si occupa di salvare la nuova entry della mappa sul database, attraverso il repository apposito.
     *
     * @param MapEntryAddRequest $request
     * @param MapEntryRepository $mapEntryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postAddEntry(MapEntryAddRequest $request, MapEntryRepository $mapEntryRepository)
    {
        $mapEntry = MapEntry::fromRequestDataArray($request->all());
        $mapEntry->user()->associate(Auth::user());

        try {
            $mapEntryRepository->save($mapEntry);
            return view('front.map_thanks');
        } catch (NotSavedException $e) {
            return redirect('mappa/aggiungi')->with('error_message', 'Problemi in fase di invio della richiesta. Riprova tra poco!');
        }
    }
}
