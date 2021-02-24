<?php

namespace AndreaMarelli\ModularForms\Helpers\API\ProtectedPlanet;

use AndreaMarelli\ModularForms\Helpers\API\API;


class ProtectedPlanet
{
    public const URL_PREFIX = 'https://api.protectedplanet.net/v3/';
    public const WEBSITE_URL = 'https://www.protectedplanet.net/';

    /**
     * Execute request to API
     *
     * @param $url
     * @param $params
     * @return array|mixed
     */
    private static function request($url, $params = []): array
    {
        $params = array_merge($params, [
            'token' => config('protected_planet_api_key')
        ]);
        return API::execute_api_request($url, $params);
    }

    /**
     * @param $country
     * @return array|mixed
     */
    public static function get_country($country): array
    {
        return self::request(self::URL_PREFIX . 'countries/' .$country);
    }

    /**
     * @param $protected_area
     * @return array|mixed
     */
    public static function get_protected_area($protected_area): array
    {
        return self::request(self::URL_PREFIX . 'protected_areas/' .$protected_area);
    }




}
