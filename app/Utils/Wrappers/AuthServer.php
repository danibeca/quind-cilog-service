<?php

namespace App\Utils\Wrappers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class AuthServer
{

    public static function getToken($oauthServerURL, $clientId, $clientSecret)
    {
        $url = $oauthServerURL . '/oauth/token';

        $data = ['grant_type'    => 'client_credentials',
                 'client_id'     => $clientId,
                 'client_secret' => $clientSecret];

        $wrapper = new HTTPWrapper();
        $result =  $wrapper->post($url,$data);
        return $result;


    }
}