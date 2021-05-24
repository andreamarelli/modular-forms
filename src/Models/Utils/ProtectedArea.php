<?php

namespace AndreaMarelli\ModularForms\Models\Utils;

use AndreaMarelli\ModularForms\Models\BaseModel;


abstract class ProtectedArea extends BaseModel
{
    protected $table = null;            // to be defined
    protected $primaryKey = null;       // to be defined

    public $incrementing = false;       // required for textual primary_key

    public const LABEL = 'name';

    public const EXPORT = [
        'global_id',
        'country',
        'wdpa_id',
        'name',
        'iucn_category',
        'creation_date'
    ];

    /**
     * Get by WDPA id
     *
     * @param string $wdpa
     * @return \AndreaMarelli\ModularForms\Models\Utils\ProtectedArea
     */
    public static function getByWdpa(string $wdpa): ProtectedArea
    {
        return static::where('wdpa_id', $wdpa)
            ->firstOrFail();
    }
}
