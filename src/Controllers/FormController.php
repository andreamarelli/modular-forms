<?php

namespace AndreaMarelli\ModularForms\Controllers;

use AndreaMarelli\ModularForms\Helpers\File\File;
use AndreaMarelli\ModularForms\Helpers\ModuleKey;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use AndreaMarelli\ModularForms\Helpers\HTTP;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


/**
 * Class FormController
 *
 * @package AndreaMarelli\ModularForms\Controllers
 */
abstract class FormController extends Controller
{

    protected static $form_class = null;
    protected static string|null $form_view_prefix = null;
    protected static string|null $form_default_step = null;

    protected const PAGINATE = true;
    protected const PER_PAGE = 50;
    protected const AUTHORIZE_BY_POLICY = false;

    public const sanitization_rules = [];

    /**
     * Manage "index" route
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request): Application|View|Factory
    {
        if(static::AUTHORIZE_BY_POLICY){
            $this->authorize('viewAny', static::$form_class);
        }

        $query_builder = (new static::$form_class())
            ->filterList($request);
        $list = static::PAGINATE
            ? $list = $query_builder->sortable()->paginate(static::PER_PAGE)
            : $query_builder->get();

        return view(static::$form_view_prefix.'.list', [
            'controller' => static::class,
            'list' => $list,
            'request' => $request
        ]);
    }

    /**
     * Manage "create" route
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): Application|View|Factory
    {
        if(static::AUTHORIZE_BY_POLICY){
            $this->authorize('create', static::$form_class);
        }
        return view(static::$form_view_prefix.'.create');
    }

    /**
     * Manage "store" route
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        if(static::AUTHORIZE_BY_POLICY){
            $this->authorize('create', static::$form_class);
        }
        $form = new static::$form_class();
        $result = $form->store($request);
        if($result['status'] === 'success'){
            $result['entity_label'] = $form::find($result['entity_id'])->{$form::LABEL};
            $result['edit_url'] = action([static::class, 'edit'], ['item' => $result['entity_id']]);
        }
        return $result;
    }

    /**
     * Manage "show" route
     *
     *@throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($item, $step=null): Application|View|Factory
    {
        if(static::AUTHORIZE_BY_POLICY){
            $this->authorize('view', (static::$form_class)::find($item));
        }
        $form = new static::$form_class();
        $form = $form->find($item);
        $step = $step ?: static::$form_default_step;
        return view(static::$form_view_prefix.'.show', [
            'controller' => static::class,
            'item' => $form,
            'step' => $step
        ]);
    }

    /**
     * Manage "print" route
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function print($item): Application|View|Factory
    {
        if(static::AUTHORIZE_BY_POLICY){
            $this->authorize('view', (static::$form_class)::find($item));
        }
        $form = new static::$form_class();
        $form = $form->find($item);
        return view(static::$form_view_prefix.'.print', [
            'controller' => static::class,
            'item' => $form,
            'mode' => 'print'
        ]);
    }

    /**
     * Manage "edit" route
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($item, $step=null): Application|View|Factory
    {
        if(static::AUTHORIZE_BY_POLICY) {
            $this->authorize('update', (static::$form_class)::find($item));
        }
        $form = new static::$form_class();
        $form = $form->find($item);
        $step = $step ?: static::$form_default_step;
        return view(static::$form_view_prefix.'.edit', [
            'controller' => static::class,
            'item' => $form,
            'step' => $step
        ]);
    }

    /**
     * Manage "update" route
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($item, Request $request): array
    {
        if(static::AUTHORIZE_BY_POLICY) {
            $this->authorize('update', (static::$form_class)::find($item));
        }
        return (static::$form_class)::updateModuleAndForm($item, $request);
    }

    /**
     * Manage "destroy" route
     *
     * @param $item
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($item): RedirectResponse
    {
        if(static::AUTHORIZE_BY_POLICY) {
            $this->authorize('destroy', (static::$form_class)::find($item));
        }
        $form = new static::$form_class();
        $form = $form->find($item);
        $form->delete();
        return redirect()->action('\\'.static::class.'@index');
    }

    /**
     * Get pair id/name list
     */
    public function getList(Request $request): array
    {
        HTTP::sanitize($request, static::sanitization_rules);

        $form_class = static::$form_class;
        return $form_class::selectionList('PAIRS',
            $form_class::filterList($request)->get()
        );
    }

    /**
     * Export: Generate and download CSV file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv(): BinaryFileResponse
    {
        $collection = (static::$form_class)::exportCollection();
        return File::exportToCSV('export.csv', $collection->toArray());
    }

    /**
     * Export: Generate and download XLS file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function xls(): BinaryFileResponse
    {
        $collection = (static::$form_class)::exportCollection();
        return File::exportToXLS('export.xls', $collection->toArray());
    }

    /**
     * API: model list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_list(Request $request): JsonResponse
    {
        $collection = (static::$form_class)::exportCollection();
        return $this->sendAPIResponse($collection, $request);
    }

    /**
     * API: info for given id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_info($id): JsonResponse
    {
        $model = (static::$form_class)::findOrFail($id);
        $models =(static::$form_class)::exportCollection($model);
        return $this->sendAPIResponse($models->toArray());
    }

}
