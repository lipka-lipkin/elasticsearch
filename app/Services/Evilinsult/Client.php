<?php

namespace App\Services\Evilinsult;

use GuzzleHttp\Client as GuzzleClient;
use \Exception;
use GuzzleHttp\Exception\ClientException;

class Client
{
    private $client;
    public $method = 'GET';
    public $data;
    private const URL = 'https://evilinsult.com/generate_insult.php';

    public function __construct(string $method, array $data){
        $this->client = new GuzzleClient();
        $this->method = $method;
        $this->data = $data;
    }

    public function request(){
        try{
            $response = $this->client->request($this->method, self::URL, $this->data);
            return $this->handleResponse($response);
        }catch(ClientException $clientException){
            dd($clientException);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    private function handleResponse($response){
        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode((string) $response->getBody(), true)
        ];
    }
}