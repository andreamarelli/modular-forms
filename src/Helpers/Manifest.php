<?php

namespace AndreaMarelli\ModularForms\Helpers;

use Illuminate\Support\Str;

class Manifest
{

    /**
     * Retrieve hashed assets path from manifest file
     */
    public static function asset($hashed_asset, $debug=false): string
    {
        $asset_path = 'vendor/modular-forms/';
        $path = public_path($asset_path);

        $manifest_path = $path . 'manifest' . ($debug ?  '-debug' : '') . '.json';
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if(!isset($manifest[$hashed_asset])){
            return $asset_path . $hashed_asset;
        }
        return $asset_path . $manifest[$hashed_asset];
    }

}
