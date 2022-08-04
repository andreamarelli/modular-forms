<?php

namespace AndreaMarelli\ModularForms\Helpers\API;

use AndreaMarelli\ModularForms\Models\Cache;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class API
{
    private const CACHE_TTL = 60 * 60 * 24 * 15;    // 15 days

    /**
     * Execute the HTTP request
     * @param $url
     * @param $params
     * @return \Illuminate\Http\Client\Response
     */
    public static function execute_request($url, $params = null): Response
    {
        return App::environment('imetoffline')
            ? Http::withOptions(['verify' => false])->get($url, $params)
            : Http::get($url, $params);
    }

    /**
     * Execute a request to the given API endpoint
     *
     * @param $url
     * @param $params
     * @return object
     */
    public static function execute_api_request($url, $params): object
    {
        // Retrieve from cache
        $cache_key = Cache::buildKey($url, $params);
        if(($cache_value = Cache::get($cache_key)) !== null){
            return static::objectFromResponse($cache_value);
        }

        // Execute request to API
        $response = API::execute_request($url, $params);
        if($response->successful()){
            // store in cache
            Cache::put($cache_key, $response, static::CACHE_TTL);
            return static::objectFromResponse($response);
        } else {
            return (object) ['error' => 'Request to '.$url.' failed'];
        }

    }

    /**
     * @param $response_value
     * @return object - json_decoded response
     */
    private static function objectFromResponse($response_value): object
    {
        $value = $response_value->json();
        return json_decode(json_encode($value));
    }
}
