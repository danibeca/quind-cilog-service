<?php

namespace App\Utils\Wrappers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class HTTPWrapper
{

    protected $password;
    protected $username;
    protected $client;
    protected $header;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client = new Client(['verify' => false, 'timeout' => 10]);
    }


    public function get($url)
    {
        //Log::info($url);

        try
        {
            $result = $this->client->get($url, $this->setAuth())->getBody()->getContents();

            return json_decode($result);

        } catch (RequestException $e)
        {
            Log::info($e->getMessage());

        } catch (ServerException $e)
        {
            Log::info($e->getMessage());
        }
    }

    public function post($url, $data)
    {
        try
        {
            $result = $this->client->post($url, ['json' => $data])->getBody()->getContents();
            Log::info($result);
            return json_decode($result);

        } catch (RequestException $e)
        {
            Log::info($e->getMessage());
        } catch (ServerException $e)
        {
            Log::info($e->getMessage());
        }
    }

    private function setAuth()
    {
        $result = [];
        if (isset($this->username))
        {
            $result = ['auth' => [$this->username, $this->password]];
        }

        return $result;
    }

    public function setToken($token)
    {
        $this->header = [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token->access_token,
        ];
        $this->client = new Client(['verify' => false, 'timeout' => 10, 'headers' => $this->header]);
    }
}