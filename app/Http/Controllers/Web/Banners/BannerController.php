<?php

namespace App\Http\Controllers\Web\Banners;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Repositories\BannerRepository;

class BannerController extends Controller
{
    public $bannerRepo;
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepo = $bannerRepository;
    }

    public function index()
    {
        $banners = $this->bannerRepo->getAllByStatus(true);
        return view('banners.index', compact('banners'));
    }

    public function getPromotional()
    {
        $banners = $this->bannerRepo->getAllByStatus(false);
        return view('banners.index', compact('banners'));
    }

    public function store(BannerRequest $request)
    {
        $this->bannerRepo->storeByRequest($request);

        return redirect()->route('banner.promotional')->with('success', 'A new banner added successfully');
    }

    public function edit(Banner $banner)
    {
        return view('banners.edit', [
            'banner' => $banner
        ]);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $this->bannerRepo->updateByRequest($request, $banner);

        return redirect()->route('banner.promotional')->with('success', 'Banner updated successfully');
    }

    public function destroy(Banner $banner)
    {
        $this->bannerRepo->deleteByRequest($banner);

        return back()->with('success', 'Banner deleted successfully');
    }

    public function toggleActivationStatus(Banner $banner)
    {
        $this->bannerRepo->toggleActivation($banner);
        return back()->with('success', 'Banner status updated successfully');
    }
}
