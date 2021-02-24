<?php

namespace AndreaMarelli\ModularForms\Controllers;

use AndreaMarelli\ModularForms\Models\ProtectedArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProtectedAreaController extends Controller
{

    /**
     * Search by search string or country
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function search(Request $request): JsonResponse
    {
        $list = collect();
        if ($request->filled('search_key') || $request->filled('country')) {
            $list = ProtectedArea::searchByKeyOrCountry($request->input('search_key'), $request->input('country'));
        }
        return response()->json(
            [
                'records' => $list->toArray(),
                'countries' => $list->pluck('country_name', 'country')
                    ->sort()
                    ->toArray()
            ]
        );
    }

    /**
     *  Get list of pairs of id/label as JSON
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getLabels(Request $request): JsonResponse
    {
        $result = [];
        if($request->filled('ids')){
            $pas = explode(',', $request->input(['ids']));
            foreach ($pas as $pa){
                $result[] = [
                    'id' => $pa,
                    'label' => ProtectedArea::find($pa)->name
                ];
            }
        }
        return response()->json($result);
    }

}
