<?php

namespace LaravelItalia\Http\Controllers\Admin;

use LaravelItalia\Domain\Template;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Domain\Repositories\TemplateRepository;
use LaravelItalia\Http\Requests\TemplateSaveRequest;

/**
 * Class TemplateController
 * @package LaravelItalia\Http\Controllers\Admin
 */
class TemplateController extends Controller
{
    /**
     * TemplateController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    /**
     * Mostra l'elenco dei template presenti nel sistema.
     *
     * @param TemplateRepository $templateRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(TemplateRepository $templateRepository)
    {
        $templates = $templateRepository->getAll();

        return view('admin.templates_index', compact('templates'));
    }

    /**
     * Mostra il form di aggiunta di un nuovo template.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd()
    {
        return view('admin.templates_add');
    }

    /**
     * Salva un nuovo template i cui dati sono passati in $request.
     *
     * @param TemplateSaveRequest $request
     * @param TemplateRepository $templateRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdd(TemplateSaveRequest $request, TemplateRepository $templateRepository)
    {
        $template = Template::fromNameAndBody(
            $request->get('name'),
            $request->get('body')
        );

        try {
            $templateRepository->save($template);
        } catch (NotSavedException $e) {
            return redirect('admin/templates/add')
                ->withInput()
                ->with('error_message', 'Problemi in fase di salvataggio. Riprovare.');
        }

        return redirect('admin/templates')->with('success_message', 'Il template è stato aggiunto correttamente.');
    }

    /**
     * Mostra il form di modifica dei dettagli di un template.
     *
     * @param TemplateRepository $templateRepository
     * @param $templateId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit(TemplateRepository $templateRepository, $templateId)
    {
        try {
            /* @var Template $template */
            $template = $templateRepository->findByid($templateId);
        } catch (NotFoundException $e) {
            return redirect('admin/templates')->with('error_message', 'Il template selezionato non è più disponibile.');
        }

        return view('admin.templates_edit', compact('template'));
    }

    /**
     * Salva le modifiche apportate ad un template esistente.
     *
     * @param TemplateSaveRequest $request
     * @param TemplateRepository $templateRepository
     * @param $templateId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(TemplateSaveRequest $request, TemplateRepository $templateRepository, $templateId)
    {
        try {
            /* @var $template Template */
            $template = $templateRepository->findByid($templateId);
        } catch (NotFoundException $e) {
            return redirect('admin/templates')->with('error_message', 'Il template selezionato non è più disponibile.');
        }

        $template->name = $request->get('name');
        $template->body = $request->get('body');

        try {
            $templateRepository->save($template);
        } catch (NotSavedException $e) {
            return redirect('admin/templates')->with('error_message', 'Errori in fase di modifica. Riprovare.');
        }

        return redirect('admin/templates/edit/' . $templateId)->with('success_message', 'Template modificato correttamente.');
    }

    /**
     * Rimuove dal sistema il template selezionato, di cui viene passato l'id.
     *
     * @param TemplateRepository $templateRepository
     * @param $templateId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete(TemplateRepository $templateRepository, $templateId)
    {
        try {
            /* @var Template $template */
            $template = $templateRepository->findByid($templateId);
        } catch (NotFoundException $e) {
            return redirect('admin/templates')->with('error_message', 'Il template scelto è stata già rimosso.');
        }

        try {
            $templateRepository->delete($template);
        } catch (NotDeletedException $e) {
            return redirect('admin/templates')->with('error_message', 'Impossibile cancellare il template scelto. Riprovare.');
        }

        return redirect('admin/templates')->with('success_message', 'Il template è stato cancellato correttamente.');
    }
}
