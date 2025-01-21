@extends('layouts.app')

@section('content')


@php
$server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');


@endphp

<div class="container-fluid">
    <div class="header pt-5">

        <div class="header-body mt-4">
            <div hidden class="row align-items-center pb-4">
                <div class="col-lg-6 col-7">
                    @if ($server == '"Windows"')
                    <h6 class="h2 d-inline-block">{{__('Dashboard')}}</h6>
                    @endif
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item "><a href="{{ route('root') }}"><i class="fa fa-home text-primary"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{__('Dashboard')}} </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                @role('customer')
                @php
                    $userid = auth()->user()->id;
                    $cst = \App\Models\Customer::where('user_id', $userid)->first();

                    $cst_id = $cst->id;

                    $garansi_cst = \App\Models\CustomerGaransis::where('customer_id', $cst_id)->get();

                    $klaim_cst = \App\Models\CustomerKlaims::where('customer_id', $cst_id)->get();
                @endphp


                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('garansi.index') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">
                                        Cek Status Garansi
                                    </h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">.
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/progress.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('garansi.index') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">Tambah Masa Proteksi</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        .
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/items.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('klaim.index') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">Klaim Garansi</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        .
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/Orders.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('setting.show', 'faq') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">Faq Garansi</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        .
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/Orders.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                @endrole


                @role('root')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('customer.index') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Users')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        @can('dashboard.calculation')
                                        {{ $customers->count() }}
                                        @else
                                        00
                                        @endcan
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/user.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('garansi.index') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Garansi')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        @can('dashboard.calculation')
                                        {{ $garansi->count() }}
                                        @else
                                        00
                                        @endcan
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/items.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <a href="{{ route('klaim.index') }}">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Klaim')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        @can('dashboard.calculation')
                                        {{ $klaim->count() }}
                                        @else
                                        00
                                        @endcan
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/Orders.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endrole

            </div>
        </div>

    </div>
</div>



@role('customer') @if ($server == '"Android"')
<div hidden class="container-fluid mt-1">
    <div class="row">


        <div class="col-12 col-lg-4">
            <div class="card" style="border-radius: 10px; border-bottom: 4px solid var(--theme-color);">
                <div class="overview">
                    <img width="100%" src="{{ asset('web/bg/overview.svg') }}" alt="">
                    <div>
                        <h2 class="text-white">{{ __('Overview') }}</h2>
                    </div>
                </div>

                <div class="row p-3">

                    <div class="col-lg-4 col-4">
                        <img width="50" src="{{ asset('images/icons/items.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark"> Klaim </h3>
                            <span class="txt-1"><a href="{{ route('klaim.create') }}"> Klik Pengajuan</a></span>
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <img width="50" src="{{ asset('images/icons/items.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark"> {{ $garansi_cst->count() }} </h3>
                            <span class="txt-1">{{ __('Garansi') }}  </span>
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <img width="50" src="{{ asset('images/icons/delivered.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark"> {{ $klaim_cst->count() }}</h3>
                            <span class="txt-1">{{ __('Klaim') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>


</div>
@endif
@endrole

<div class="container m-4 pt-6">

    @php
        $banner = \App\Models\Banner::get();
    @endphp
    <div class="slider-wrapper">
        <button id="prev-slide" class="slide-button material-symbols-rounded">
            chevron_left
        </button>
        <ul class="image-list">
            @foreach ($banner as $banners )

                @php
                $get_media = DB::table('media')->where('id', $banners ->thumbnail_id)->first();
                @endphp

                @php
                    $ext    = pathinfo($get_media->path, PATHINFO_EXTENSION);
                @endphp

                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'jpeg')
                    <img class="image-item"  src="{{ Storage::url($get_media->path);  }}" alt="img-1" />
                @endif

                @if ($ext == 'pdf')
                    <div class="image-item text-center">
                        <h3>{{ $banners->title }} </h3>
                        <p>{{ $banners->description }}</p>
                        <a target="_blank" class="btn btn-sm btn-danger" href="{{ Storage::url($get_media->path);  }}" alt="">View PDF </a>
                    </div>
                @endif

                @if ($ext == 'xlsx' || $ext == 'xls' || $ext == 'csv')
                    <div class="image-item text-center">
                        <h3>{{ $banners->title }} </h3>
                        <p>{{ $banners->description }}</p>
                        <a target="_blank" class="btn btn-sm btn-success" href="{{ Storage::url($get_media->path);  }}" alt="">View Excel </a>
                    </div>
                @endif
            @endforeach
        </ul>
        <button id="next-slide" class="slide-button material-symbols-rounded">
            chevron_right
        </button>
    </div>
    <div class="slider-scrollbar">
        <div class="scrollbar-track">
            <div class="scrollbar-thumb"></div>
        </div>
    </div>

</div>




@push('scripts')
    <script>
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00B894',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>
    <script>
        const initSlider = () => {
            const imageList = document.querySelector(".slider-wrapper .image-list");
            const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
            const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
            const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
            const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;

            // Handle scrollbar thumb drag
            scrollbarThumb.addEventListener("mousedown", (e) => {
                const startX = e.clientX;
                const thumbPosition = scrollbarThumb.offsetLeft;
                const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;

                // Update thumb position on mouse move
                const handleMouseMove = (e) => {
                    const deltaX = e.clientX - startX;
                    const newThumbPosition = thumbPosition + deltaX;

                    // Ensure the scrollbar thumb stays within bounds
                    const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
                    const scrollPosition = (boundedPosition / maxThumbPosition) * maxScrollLeft;

                    scrollbarThumb.style.left = `${boundedPosition}px`;
                    imageList.scrollLeft = scrollPosition;
                }

                // Remove event listeners on mouse up
                const handleMouseUp = () => {
                    document.removeEventListener("mousemove", handleMouseMove);
                    document.removeEventListener("mouseup", handleMouseUp);
                }

                // Add event listeners for drag interaction
                document.addEventListener("mousemove", handleMouseMove);
                document.addEventListener("mouseup", handleMouseUp);
            });

            // Slide images according to the slide button clicks
            slideButtons.forEach(button => {
                button.addEventListener("click", () => {
                    const direction = button.id === "prev-slide" ? -1 : 1;
                    const scrollAmount = imageList.clientWidth * direction;
                    imageList.scrollBy({ left: scrollAmount, behavior: "smooth" });
                });
            });

            // Show or hide slide buttons based on scroll position
            const handleSlideButtons = () => {
                slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "flex";
                slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "flex";
            }

            // Update scrollbar thumb position based on image scroll
            const updateScrollThumbPosition = () => {
                const scrollPosition = imageList.scrollLeft;
                const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
                scrollbarThumb.style.left = `${thumbPosition}px`;
            }

            // Call these two functions when image list scrolls
            imageList.addEventListener("scroll", () => {
                updateScrollThumbPosition();
                handleSlideButtons();
            });
        }

        window.addEventListener("resize", initSlider);
        window.addEventListener("load", initSlider);
    </script>
@endpush
@endsection
