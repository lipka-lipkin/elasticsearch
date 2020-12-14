<?php

namespace App\Services\Evilinsult\Actions;

use App\Models\User;
use App\Services\Evilinsult\Client;

class GetEvil extends Client
{
    public static function make(User $user){
        $data = ['query' => ['lang' => $user->lang, 'type' => 'json']];
        $client = new Client('GET', $data);
        $response = $client->request();
        dd($response);
    }
}