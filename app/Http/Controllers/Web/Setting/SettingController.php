<?php

namespace App\Http\Controllers\Web\Setting;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Repositories\SettingRepository;

class SettingController extends Controller
{
    private $settingRepo;
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepo = $settingRepository;
    }

    public function show($slug)
    {
        $setting = $this->settingRepo->findBySlug($slug);

        return view('settings.index', compact('setting'));
    }

    public function edit($slug)
    {
        $setting = $this->settingRepo->findBySlug($slug);

        return view('settings.edit', compact('setting'));
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        $this->settingRepo->updateByRequest($request, $setting);

        return back();
    }

}
