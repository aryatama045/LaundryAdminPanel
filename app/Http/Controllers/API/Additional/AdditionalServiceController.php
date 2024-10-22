<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdditionalServiceResource;
use App\Repositories\AdditionalRepository;

class AdditionalServiceController extends Controller
{
    public function index()
    {
        $service = \request('service_id');
        $additionalServices = (new AdditionalRepository())->getByService($service);

        return $this->json('Additional service list', [
            'additional_services' => AdditionalServiceResource::collection($additionalServices)
        ]);
    }
}
