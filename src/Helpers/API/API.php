<?php

namespace AndreaMarelli\ModularForms\Helpers\API;

use AndreaMarelli\ModularForms\Models\Cache;
use Exception;
use Illuminate\Support\Facades\Http;

class API
{
    private const CACHE_TTL = 60 * 60 * 24 * 15;    // 15 days

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
            return (object) $cache_value;
        }

        // Execute request to API
        $response = Http::get($url, $params);
        if($response->successful()){
            $response_json = $response->json();
            // store in cache
            Cache::put($cache_key, $response, static::CACHE_TTL);
            return json_decode(json_encode($response_json));
        } else {
            return (object) ['error' => 'Request to '.$url.' failed'];
        }

    }
}
