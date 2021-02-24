<?php

namespace AndreaMarelli\ModularForms\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProtectedArea
 *
 * @property string $name
 * @package AndreaMarelli\ModularForms\Models
 */
class ProtectedArea extends BaseModel
{
    public const LABEL = 'name';

    /**
     * Scope a query by search key
     *
     * @param Builder $query
     * @param string $searchKey
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLike(Builder $query, string $searchKey): Builder
    {
        if($searchKey!==null && $searchKey!==''){
            $query = $query->where('name', '~~*', '%' . $searchKey . '%');
            if(is_numeric($searchKey)){
                $query =  $query->orWhere('wdpa_id', $searchKey);
            }
        }
        return $query;
    }

    /**
     * Search by key or country
     *
     * @param string $search_key
     * @param null $country
     * @return \Illuminate\Support\Collection
     */
    public static function searchByKeyOrCountry(string $search_key, $country = null): \Illuminate\Support\Collection
    {
        $pas = static::like($search_key)
            ->where(function ($query) use($country) {
                if($country!==null && $country!=='' && $country!=='null') {
                    $query->where('country', $country);
                }
            })
            ->orderBy('name')
            ->get();

        $countries = Country::select(['iso3', 'name_'.LOWER_LOCALE])
            ->whereIn('iso3', array_values($pas->pluck('country')->unique()->toArray()))
            ->pluck('name_'.LOWER_LOCALE, 'iso3')
            ->sort()
            ->toArray();

        return $pas->map(function($item) use($countries){
            $item['country_name'] = $countries[$item->country];
            return $item;
        });
    }

    /**
     * Get by WDPA id
     *
     * @param string $wdpa
     * @return \AndreaMarelli\ModularForms\Models\ProtectedArea
     */
    public static function getByWdpa(string $wdpa): ProtectedArea
    {
        return static::where('wdpa_id', $wdpa)
            ->firstOrFail();
    }

    /**
     * Get protected areas' countries
     * @return array
     */
    public static function getCountries(): array
    {
        $countries = static::selectRaw('regexp_split_to_table(country, \'\;\') as iso3')
            ->distinct()
            ->get()
            ->pluck('iso3')
            ->sort()
            ->toArray();

        return Country::select(['iso3', 'name_'.LOWER_LOCALE])
            ->whereIn('iso3', array_values($countries))
            ->pluck('name_'.LOWER_LOCALE, 'iso3')
            ->sort()
            ->toArray();
    }

    /**
     * Retrieve an array for selection lists (with WDPA as id)
     * @return array
     */
    public static function selectionWdpaList(): array
    {
        return static::all()
            ->sortBy(static::LABEL, SORT_NATURAL|SORT_FLAG_CASE)
            ->pluck(static::LABEL, 'wdpa_id')
            ->toArray();
    }

}
