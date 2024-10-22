<?php


namespace App\Repositories;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SocialLinkRepository extends Repository
{
    private $path = 'images/social/';
    public function model()
    {
        return SocialLink::class;
    }

    public function getAll()
    {
      return  $this->model()::all();
    }

    public function storeByRequest(Request $request)
    {
        $thumbnail = null;
        if ($request->hasFile('photo')) {
            $thumbnail = (new MediaRepository())->storeByRequest(
                $request->photo,
                $this->path,
                'social images',
                'image'
            );
        }
        $social = $this->model()::create([
            'name' => $request->name,
            'url' => $request->url,
            'media_id' =>  $thumbnail ? $thumbnail->id : null
        ]);

        return $social;
    }


    public function updateByRequest(Request $request, $social): SocialLink
    {
        $thumbnail = $this->socialImageUpdate($request, $social);

        $social->update([
            'name' => $request->name,
            'url' => $request->url,
            'media_id' =>  $thumbnail ? $thumbnail->id : null,
        ]);

        return $social;
    }

    private function socialImageUpdate($request, $social)
    {
        $thumbnail = $social->photo;
        if ($request->hasFile('photo') && $thumbnail == null) {
            $thumbnail = (new MediaRepository())->storeByRequest(
                $request->photo,
                $this->path,
                'social images',
                'image'
            );
        }
        if ($request->hasFile('photo') && $thumbnail) {
            $thumbnail = (new MediaRepository())->updateByRequest(
                $request->photo,
                $this->path,
                'image',
                $thumbnail
            );
        }

        return $thumbnail;
    }

    public function deleteByRequest(SocialLink $socialLink)
    {
        $thumbnail = $socialLink->photo;
        if (Storage::exists($thumbnail->src)) {
            Storage::delete($thumbnail->src);
        }

        $socialLink->delete();
        $thumbnail->delete();
        return;
    }
}
