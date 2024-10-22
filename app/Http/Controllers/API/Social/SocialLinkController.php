<?php

namespace App\Http\Controllers\API\Social;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialLinkResource;
use App\Repositories\SocialLinkRepository;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLink = (new SocialLinkRepository())->getAll();
        return $this->json('Social links',[
            'socialLink' =>  SocialLinkResource::collection($socialLink)
        ]);
    }
}
