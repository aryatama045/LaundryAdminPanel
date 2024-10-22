<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Repositories\ServiceRepository;

class ServiceController extends Controller
{
    public function index()
    {
        $services = (new ServiceRepository())->getActiveServices();
        return $this->json('service list', [
            'services' => ServiceResource::collection($services)
        ]);
    }
}
