<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaravelItalia\Entities\Factories\SeriesFactory;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Requests\SeriesSaveRequest;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Http\Requests;
use LaravelItalia\Entities\Series;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Entities\Repositories\SeriesRepository;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    public function getIndex(SeriesRepository $seriesRepository)
    {
        $series = $seriesRepository->getAll();

        return view('admin.series_index', compact('series'));
    }

    public function getAdd()
    {
        return view('admin.series_add');
    }

    public function postAdd(SeriesSaveRequest $request, SeriesRepository $seriesRepository)
    {
        $series = SeriesFactory::createSeries(
            $request->get('title'),
            $request->get('description'),
            $request->get('metadescription')
        );

        try {
            $seriesRepository->save($series);
        } catch (NotSavedException $e) {
            return redirect('admin/series/add')
                ->withInput()
                ->with('error_message', 'Problemi in fase di salvataggio. Riprovare.');
        }

        return redirect('admin/series')->with('success_message', 'La serie è stata aggiunta correttamente.');
    }

    public function getPublish(SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie selezionata non è più disponibile.');
        }

        $series->is_published = true;

        try {
            $seriesRepository->save($series);
        } catch (\Exception $e) {
            return redirect('admin/series')->with('error_message', 'Errori in fase di modifica. Riprovare.');
        }

        return redirect('admin/series')->with('success_message', 'La serie è stata messa in pubblicazione correttamente.');
    }

    public function getUnpublish(SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie selezionata non è più disponibile.');
        }

        $series->is_published = false;

        try {
            $seriesRepository->save($series);
        } catch (\Exception $e) {
            return redirect('admin/series')->with('error_message', 'Errori in fase di modifica. Riprovare.');
        }

        return redirect('admin/series')->with('success_message', 'La serie è stata rimossa dalla pubblicazione correttamente.');
    }

    public function getComplete(SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie selezionata non è più disponibile.');
        }

        $series->is_completed = true;

        try {
            $seriesRepository->save($series);
        } catch (\Exception $e) {
            return redirect('admin/series')->with('error_message', 'Errori in fase di modifica. Riprovare.');
        }

        return redirect('admin/series')->with('success_message', 'La serie è stata contrassegnata come completata.');
    }

    public function getIncomplete(SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie selezionata non è più disponibile.');
        }

        $series->is_completed = false;

        try {
            $seriesRepository->save($series);
        } catch (\Exception $e) {
            return redirect('admin/series')->with('error_message', 'Errori in fase di modifica. Riprovare.');
        }

        return redirect('admin/series')->with('success_message', 'La serie è stata contrassegnata come non completata.');
    }

    public function getEdit(SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie selezionata non è più disponibile.');
        }

        return view('admin.series_edit', compact('series'));
    }

    public function postEdit(SeriesSaveRequest $request, SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie selezionata non è più disponibile.');
        }

        $series->title = $request->get('title');
        $series->description = $request->get('description');
        $series->metadescription = $request->get('metadescription');

        try {
            $seriesRepository->save($series);
        } catch (\Exception $e) {
            return redirect('admin/series')->with('error_message', 'Errori in fase di modifica. Riprovare.');
        }

        return redirect('admin/series/edit/' . $seriesId)->with('success_message', 'Serie modificata correttamente.');
    }

    public function getDelete(SeriesRepository $seriesRepository, $seriesId)
    {
        try {
            /* @var $series Series */
            $series = $seriesRepository->findByid($seriesId);
        } catch (NotFoundException $e) {
            return redirect('admin/series')->with('error_message', 'La serie scelta è stata già rimossa.');
        }

        try {
            $seriesRepository->delete($series);
        } catch (NotDeletedException $e) {
            return redirect('admin/series')->with('error_message', 'Impossibile cancellare la serie scelta. Riprovare.');
        }

        return redirect('admin/series')->with('success_message', 'La serie è stata cancellata correttamente.');
    }
}
