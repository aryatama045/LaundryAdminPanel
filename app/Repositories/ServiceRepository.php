<?php

namespace App\Repositories;

use App\Repositories\MediaRepository;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

class ServiceRepository extends Repository
{
    private $path = 'images/services/';
    public function model()
    {
        return Service::class;
    }

    public function getAll($isLatest = false)
    {
        $category = $this->model()::query();
        if ($isLatest) {
            $category->latest('id');
        }
        return $category->get();
    }

    public function getActiveServices()
    {
        return Service::isActive()->get();
    }

    public function storeByRequest(ServiceRequest $request)
    {
        $variantIds = $request->variant_ids;
        $thumbnail = (new MediaRepository())->storeByRequest(
            $request->image,
            $this->path,
            'this image for service thumbnail',
            'image'
        );

        $service = $this->model()::create([
            'name' => $request->name,
            'description' => $request->description,
            'name_bn' => $request->name_bn,
            'description_bn' => $request->description_bn,
            'thumbnail_id' => $thumbnail->id,
        ]);

        $service->variants()->sync($variantIds);

        return $service;
    }

    public function updateByRequest(ServiceRequest $request, Service $service): Service
    {
        $variantIds = $request->variant_ids ? $request->variant_ids : $service->variants->pluck('id')->toArray();
        if ($request->hasFile('image')) {
            (new MediaRepository())->updateByRequest(
                $request->image,
                $this->path,
                'image',
                $service->thumbnail
            );
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'name_bn' => $request->name_bn,
            'description_bn' => $request->description_bn,
            'amount' => $request->amount,
        ]);

        $service->variants()->sync($variantIds);

        return $service;
    }

    public function updateStatusById(Service $service): Service
    {
        $service->update([
            'is_active' => !$service->is_active
        ]);

        return $service;
    }

    public function findOrFailById($serviceId): Service
    {
        $service = $this->model()::findOrFail($serviceId);

        return $service;
    }
}
