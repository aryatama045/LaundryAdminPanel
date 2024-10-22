<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Repositories\AreaRepository;

class AreaController extends Controller
{
    public function index()
    {
        $areas = (new AreaRepository())->getAllByActive();
        return  $this->json('Area list', [
            'areas' => AreaResource::collection($areas)
        ]);
    }
}
