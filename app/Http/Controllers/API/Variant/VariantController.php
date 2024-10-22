<?php

namespace App\Http\Controllers\API\Variant;

use App\Http\Controllers\Controller;
use App\Http\Resources\VariantResource;
use App\Repositories\VariantRepository;

class VariantController extends Controller
{
    public function index()
    {
        $serviceId = \request('service_id');
        $variants = (new VariantRepository())->findByServiceId($serviceId);

        return $this->json('variant list', [
            'variants' => VariantResource::collection($variants)
        ]);
    }
}
