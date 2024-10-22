<?php


namespace App\Repositories;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaRepository extends Repository
{
    public function model()
    {
        return Area::class;
    }

    public function getAllByActive()
    {
        return $this->query()->where('status', true)->get();
    }

    public function storeByRequest(Request $request): Area
    {
        return $this->create([
            'country_id' => $request->country_id,
            'name' => $request->name
        ]);
    }

    public function updateByRequest(Area $area, Request $request): Area
    {
        $this->update($area, [
            'country_id' => $request->country_id,
            'name' => $request->name
        ]);
        return $area;
    }

    public function toggleStaus(Area $area): Area
    {
        $this->update($area, [
            'status' => !$area->status
        ]);
        return $area;
    }
}
