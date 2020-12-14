<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Evilinsult\Actions\GetEvil;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    public function evil(Request $request){
        $response = GetEvil::make($request->user());
    }
}
