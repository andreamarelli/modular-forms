<?php

namespace AndreaMarelli\ModularForms\Controllers;

use AndreaMarelli\ModularForms\Helpers\HTTP;
use AndreaMarelli\ModularForms\Models\Animal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class SpeciesController extends Controller
{
    public const sanitization_rules = [
        'class' => 'required_without:search|max:25|alpha|in:amphibians,birds,butterflies,fishes,mammals,reptiles',
        'order' => 'max:25|alpha|nullable',
        'family' => 'max:25|alpha|nullable',
        'tab' => 'max:25|alpha_dash',
        'search' => 'alpha|nullable',
    ];

    /**
     * Search Species by key
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function search(Request $request): JsonResponse
    {
        $list = collect();
        $classes = $ordersByClass = [];

        if($request->filled('search_key')){

            $list = Animal::searchSpecies($request->input('search_key'))
                ->map(function ($item){
                    if($item['iucn_redlist_category']==="LR/nt"){
                        $item['iucn_redlist_category'] = 'NT';
                    }
                    if($item['iucn_redlist_category']==="LR/lc"){
                        $item['iucn_redlist_category'] = 'LC';
                    }
                    return $item;
                });

            $taxonomy = $list
                ->map(function ($item) {
                    return [
                        'class' => $item['class'],
                        'order' => $item['order']
                    ];
                })
                ->toArray();

            $ordersByClass = [];
            foreach ($taxonomy as $t){
                if(!array_key_exists($t['class'], $ordersByClass)){
                    $ordersByClass[$t['class']] = [];
                }
                if(!in_array($t['order'], $ordersByClass[$t['class']])){
                    $ordersByClass[$t['class']][] = $t['order'];
                }
                sort($ordersByClass[$t['class']]);
            }

            $classes = array_keys($ordersByClass);
            sort($classes);
        }

        return response()->json([
            'records' => $list->toArray(),
            'classes' => $classes,
            'orders' => $ordersByClass
        ]);
    }


}
