<?php

namespace App\Repositories;

use App\Http\Requests\SettingRequest;
use App\Models\OrderSchedule;
use App\Models\Setting;

class ScheduleRepository extends Repository
{
    public function model()
    {
        return OrderSchedule::class;
    }

    public function findByDay(string $day, $type)
    {
        return $this->query()->where('type', $type)->where('is_active', true)->where('day', $day)->first();
    }

    public function getByType(string $type)
    {
        return $this->query()->where('type', $type)->get();
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
