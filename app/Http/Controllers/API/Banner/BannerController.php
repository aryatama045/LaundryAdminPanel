<?php

namespace App\Http\Controllers\API\Banner;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Repositories\BannerRepository;

class BannerController extends Controller
{
    public function index()
    {
        $banners = (new BannerRepository())->getByBannerStatus(true);

        return $this->json('banner list', [
            'banners' => BannerResource::collection($banners)
        ]);
    }
}
