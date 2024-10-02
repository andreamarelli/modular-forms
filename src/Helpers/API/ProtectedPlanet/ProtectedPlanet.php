<?php

namespace AndreaMarelli\ModularForms\Helpers\API\ProtectedPlanet;

use AndreaMarelli\ModularForms\Helpers\API\API;


class ProtectedPlanet
{
    public const WEBSITE_URL = 'https://www.protectedplanet.net/';
    private const API_URL = 'https://api.protectedplanet.net/v3/';

    /**
     * Execute request to API
     */
    private static function request($url, array $params = []): object
    {
        $params = array_merge($params, [
            'token' => config('modular-forms.protected_planet_api_key')
        ]);
        return API::execute_api_request($url, $params);
    }

    /**
     * Execute API request: retrieve protected areas by given country
     */
    public static function getByCountry(string $country, int $page = 1, int $per_page = 50): object
    {
        return self::request(self::API_URL . 'protected_areas/search', [
            'country' => $country,
            'page' => $page,
            'per_page' => 50
        ]);
    }

}
