<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait GetRequestTrait
{
    /**
     * Make a GET request to the API.
     *
     * @param string $url
     * @param array $params
     * @return Response
     */
    public function getRequest(string $url, array $params = []): Response
    {
        return Http::get($url, $params);
    }
}