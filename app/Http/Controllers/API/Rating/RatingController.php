<?php

namespace App\Http\Controllers\API\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Repositories\OrderRepository;
use App\Repositories\RatingRepository;

class RatingController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        $ratings = (new RatingRepository())->getByCustomer($customer);

        if($ratings->isEmpty()){
            return $this->json('sorry, ratings not found', []);
        }

        return $this->json('rating list', [
            'ratings' => RatingResource::collection($ratings)
        ]);
    }

    public function store(RatingRequest $request)
    {
        $order = (new OrderRepository())->findById($request->order_id);

        if($order->order_status == config('enums.order_status.delivered')){
            $rating = (new RatingRepository())->storeByRequest($request);

            return $this->json('Thank for your rating', [
                'rating' => new RatingResource($rating)
            ]);
        }

        return $this->json('sorry, You can\'t review this order', []);
    }
}
