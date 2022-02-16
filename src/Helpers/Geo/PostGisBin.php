<?php

namespace AndreaMarelli\ModularForms\Helpers\Geo;

class PostGisBin{

    /**
     * Execute a shp2pgsql command
     *
     * @param $shp_path
     * @param $table_name
     * @return string
     */
    public static function shp2pgsql($shp_path, $table_name): string
    {
        if(env('SHP2PGSQL')===null){
            dd('SHP2PGSQL not defined in .env');
        }

        $sql_path = $shp_path . '.sql';
        $command = env('SHP2PGSQL').' ' . $shp_path . ' "' . $table_name . '"';

        system($command . ' > ' . $sql_path, $result_code);
        if($result_code!==0){
            dd('Error in executing command:  '.$command);
        }
        return $sql_path;
    }
}
