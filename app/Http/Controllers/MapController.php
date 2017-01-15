<?php

namespace LaravelItalia\Http\Controllers;

use Auth;
use LaravelItalia\Domain\MapEntry;
use LaravelItalia\Domain\Repositories\MapEntryRepository;
use LaravelItalia\Events\MapEntryHasBeenRegistered;
use LaravelItalia\Exceptions\NotFoundException;
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

    /**
     * Si occupa di confermare l'inserimento di una nuova entry nella mappa, usando il token.
     *
     * @param MapEntryRepository $mapEntryRepository
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getConfirm(MapEntryRepository $mapEntryRepository, $token)
    {
        try {
            /** @var MapEntry $mapEntry */
            $mapEntry = $mapEntryRepository->findByConfirmationToken($token);
            $mapEntry->confirm();
            $mapEntryRepository->save($mapEntry);

        } catch (NotFoundException $e) {
            return view('errors.500');
        } catch (NotSavedException $e) {
            return view('errors.500');
        }

        return view('front.map_confirm', ['mapEntry' => $mapEntry]);
    }
}
