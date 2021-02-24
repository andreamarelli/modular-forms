<?php

namespace AndreaMarelli\ModularForms\Helpers\Type;

class JSON{

    /**
     * Check if the given string is a valid JSON
     *
     * @param $string
     * @return bool
     */
    public static function isJson($string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Print the given JSON data into a Vue data attribute
     *
     * @param $data
     * @return string
     */
    public static function toVue($data): string
    {
        $data_json = json_encode($data);
        $data_json = addslashes($data_json);
        return $data_json;
    }

}
