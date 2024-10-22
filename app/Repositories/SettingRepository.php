<?php


namespace App\Repositories;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

class SettingRepository extends Repository
{
    public function model()
    {
        return Setting::class;
    }

    public function findBySlug($slug)
    {
       return $this->model()::where('slug', $slug)->first();
    }

    public function updateByRequest(SettingRequest $request, Setting $setting): Setting
    {
        $setting->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return $setting;
    }

}
