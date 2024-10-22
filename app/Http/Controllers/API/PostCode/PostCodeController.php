<?php

namespace App\Http\Controllers\API\PostCode;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCodeResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class PostCodeController extends Controller
{
    public function index()
    {
        $request_postCode = request('postcode');

        $twoDigitis = substr($request_postCode, 0, 2);
        $threeDigitis = substr($request_postCode, 0, 3);
        $fourDigitis = substr($request_postCode, 0, 4);

        $allAreCode = config('enums.post_code');
        $postCode = '';

        foreach ($allAreCode as $areCode) {
            if ($areCode == $twoDigitis) {
                $postCode = $twoDigitis;
            }
        }

        foreach ($allAreCode as $areCode) {
            if ($areCode == $threeDigitis) {
                $postCode = $threeDigitis;
            }
        }

        foreach ($allAreCode as $areCode) {
            if ($areCode == $fourDigitis) {
                $postCode = $fourDigitis;
            }
        }

        if ($postCode) {
            $response = Http::get('https://api.ideal-postcodes.co.uk/v1/postcodes/' . $request_postCode . '?api_key=ak_l4xvqpl2ipEKJoSvhXlnIMhDyPZa7');
            if ($response->status() == 200) {
                $result = $response->json();
                return $this->json('Post Code List', [
                    $result
                ]);
            }
            return $this->json('Post code not found', [], Response::HTTP_BAD_REQUEST);
        }
        return $this->json('You are currently outside of our service area', [], Response::HTTP_BAD_REQUEST);




        //  dd($response->status());
        //  ,$response->body()
    }
}
