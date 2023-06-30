Copy code
<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait PostRequestTrait
{
    /**
     * Make a POST request to the API.
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function postRequest(string $url, array $data): Response
    {
        return Http::post($url, $data);
    }
}