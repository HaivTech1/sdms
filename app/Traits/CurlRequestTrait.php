<?php

namespace App\Traits;

trait CurlRequestTrait
{
    public function getRequest(string $url, array $params = [])
    {
        $ch = curl_init();
        $token = env('IMPRESSION_TOKEN');
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($token) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
        }

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public function postRequest(string $url, array $data = [])
    {
        $ch = curl_init();
        $token = env('IMPRESSION_TOKEN');
        curl_setopt($ch, CURLOPT_URL, $url);

        $headers = ["Content-Type: application/json"];
        if ($token) {
            $headers[] = "Authorization: Bearer $token";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
