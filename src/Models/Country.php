<?php

namespace AndreaMarelli\ModularForms\Models;

use Exception;


/**
 * Class Country
 *
 * @property string $name
 * @property string $iso2
 * @property string $iso3
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package AndreaMarelli\ModularForms\Models\Country
 */
class Country extends BaseModel
{
    protected $primaryKey = 'iso3';
    public $incrementing = false;

    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public const UPDATED_BY = null;

    protected $appends = [
        'name'
    ];

    /**
     * Append "name" (in the local language) to attributes list for better access
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->attributes[static::LABEL];
    }

    /**
     * Get country by iso
     *
     * @param $iso
     * @return mixed
     * @throws \Exception
     */
    public static function getByISO($iso)
    {
        $iso = strtoupper($iso);
        if(strlen($iso)==2){
            return static::where('iso2', $iso)->first();
        } elseif(strlen($iso)==3){
            return static::where('iso3', $iso)->first();
        } else {
            throw new Exception('Wrong size for iso: '. $iso);
        }
    }

    /**
     * Get an array with iso2, iso3 and name
     *
     * @param $iso
     * @return array
     * @throws \Exception
     */
    public static function getIsoNamePair($iso): array
    {
        if($iso!==null){
            $country = static::getByISO($iso);
            return [
                'iso3' => $country->iso3,
                'iso2' => $country->iso2,
                'name' => $country->name
            ];
        }
        return ['iso3'=>'', 'iso2'=>'', 'name'=>''];
    }

}
