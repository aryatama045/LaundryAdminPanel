<?php

namespace App\Http\Controllers\API\Promotion;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Repositories\BannerRepository;

class PromotionController extends Controller
{
    public function index()
    {
        #todo this banner should be replaced by promotion
        $banners = (new BannerRepository())->getByBannerStatus(false);

        return $this->json('Promotion list', [
            'promotions' => PromotionResource::collection($banners)
        ]);
    }
}
