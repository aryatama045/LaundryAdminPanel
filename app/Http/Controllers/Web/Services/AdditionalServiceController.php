<?php

namespace App\Http\Controllers\Web\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionalRequest;
use App\Models\Additional;
use App\Repositories\AdditionalRepository;

class AdditionalServiceController extends Controller
{
    public $additionalRepo;
    public function __construct(AdditionalRepository $additionalRepository)
    {
        $this->additionalRepo = $additionalRepository;
    }

    public function index()
    {
        $additionals = $this->additionalRepo->getAll(true);
        return view('additional-services.index', compact('additionals'));
    }

    public function create()
    {
        return view('additional-services.create');
    }

    public function store(AdditionalRequest $request)
    {
       $this->additionalRepo->storeByRequest($request);

       return redirect()->route('additional.index');
    }

    public function edit(Additional $additional)
    {
        return view('additional-services.edit', compact('additional'));
    }

    public function update(AdditionalRequest $request, Additional $additional)
    {
        $this->additionalRepo->updateByRequest($request, $additional);

        return redirect()->route('additional.index');
    }

    public function toggleActivationStatus(Additional $additional)
    {
        $this->additionalRepo->updateStatusById($additional);

        return back();
    }
}
