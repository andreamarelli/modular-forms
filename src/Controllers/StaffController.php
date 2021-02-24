<?php

namespace AndreaMarelli\ModularForms\Controllers;

use AndreaMarelli\ModularForms\Models\Country;
use AndreaMarelli\ModularForms\Models\User\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * Class StaffController
 *
 * @package AndreaMarelli\ModularForms\Controllers
 */
class StaffController extends FormController
{
    protected static $form_class = Person::class;
    protected static $form_view = 'person';
    protected static $form_default_step = 'general_info';

    public const AUTHORIZE_BY_POLICY = true;

    /**
     * Override index(): allow filter by initial letter
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Person::class);

        $countries = Country::all()->map->only(['iso2', 'iso3', 'name'])->keyBy('iso3')->toArray();
        $list = Person::
            select(['id', 'first_name', 'last_name', 'organisation', 'function', 'country', 'role_ofac'])
            ->with('user')
            ->get()
            ->makeHidden(['first_name', 'last_name', 'user'])
            ->map(function ($item) use($countries) {
                $item->has_user = $item->user->password !== null;
                $item->country = array_key_exists($item->country, $countries) ? $countries[$item->country] : null;
                return $item;
            })
            ->toArray();

        return view('admin.person.list', [
            'controller' => static::class,
            'list' => $list
        ]);
    }

    /**
     * Search
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function search(Request $request): JsonResponse
    {
        $list = $request->filled('search_key')
            ? Person::searchByKey($request->input('search_key'))
            : collect();

        return response()->json([
            'records' => $list->toArray()
        ]);
    }

}
