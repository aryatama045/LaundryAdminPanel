<?php

namespace App\Repositories;

use App\Http\Requests\VariantRequest;
use App\Models\Variant;

class VariantRepository extends Repository
{
    public function model()
    {
        return Variant::class;
    }

    public function getAll()
    {
        return $this->model()::orderBy('position', 'asc')->get();
    }

    public function findByServiceId($serviceId)
    {
        $service = (new ServiceRepository())->findOrFailById($serviceId);

        return $service->variants;
    }

    public function storeByRequest(VariantRequest $request): Variant
    {
        return $this->model()::create([
            'name' => $request->name,
            'name_bn' => $request->name_bn,
            'position' => $request->position,
        ]);
    }

    public function updateByRequest(VariantRequest $request, Variant $variant): Variant
    {
        $variant->update([
            'name' => $request->name,
            'name_bn' => $request->name_bn,
            'position' => $request->position,
        ]);
        return $variant;
    }

}
