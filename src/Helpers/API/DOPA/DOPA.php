<?php

namespace AndreaMarelli\ModularForms\Helpers\API\DOPA;

use AndreaMarelli\ModularForms\Helpers\API\API;

class DOPA
{
    use Country;
    use Wdpa;

    public const URL_PREFIX = 'https://dopa-services.jrc.ec.europa.eu/services/';

    public const ON_ERROR_RESPONSE = 0;
    public const ON_ERROR_NULL = 1;
    public const ON_ERROR_ARRAY = 2;
    public const ON_ERROR_MESSAGE = 3;

    /**
     * Execute request to API
     *
     * @param string $url
     * @param array $params
     * @param int $on_error
     * @return array|null
     */
    protected static function request(string $url, array $params, int $on_error = DOPA::ON_ERROR_RESPONSE): ?array
    {
        $response = (array) API::execute_api_request($url, $params);

        if(DOPA::response_has_error($response)){
            if($on_error === DOPA::ON_ERROR_ARRAY){
                return [];
            } else if($on_error === DOPA::ON_ERROR_NULL){
                return null;
            } else if($on_error === DOPA::ON_ERROR_RESPONSE){
                return $response;
            } else if($on_error === DOPA::ON_ERROR_MESSAGE){
                return $response['metadata']['error'];
            }
        } else {
            return $response['error'];
        }
        return $response;
    }

    /**
     * Check if the API return contains error
     *
     * @param array $response
     * @return bool
     */
    private static function response_has_error(array $response): bool
    {
        return array_key_exists('error',$response)
            or (
                array_key_exists('metadata', $response)
                and array_key_exists('error', $response['metadata'])
            );
    }

    /**
     * Check if API is available
     *
     * @return bool
     */
    public static function apiAvailable(): bool
    {
        try{
            return file_get_contents(static::URL_PREFIX)!=='';
        } catch (\Exception $e){
            return false;
        }

    }

}
