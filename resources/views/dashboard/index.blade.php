@extends('layouts.app')

@section('content')


@php
$server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');


@endphp

<div class="container-fluid">
    <div class="header pt-5">

        <div class="header-body mt--4">
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
                @if ($server == '"Windows"')

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0"><a href="{{ route('klaim.create') }}">
                                        Klik Pengajuan
                                        </a></h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">.
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/items.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Garansi ')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        {{ $garansi_cst->count() }}
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/items.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Klaim ')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        {{ $klaim_cst->count() }}
                                    </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/services.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif


                @endrole


                @role('root')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
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
                        </div>
                    </div>
                </div>
                @endrole

            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="slider-wrapper">
      <button id="prev-slide" class="slide-button material-symbols-rounded">
        chevron_left
      </button>
      <ul class="image-list">
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-1.jpg" alt="img-1" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-2.jpg" alt="img-2" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-3.jpg" alt="img-3" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-4.jpg" alt="img-4" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-5.jpg" alt="img-5" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-6.jpg" alt="img-6" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-7.jpg" alt="img-7" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-8.jpg" alt="img-8" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-9.jpg" alt="img-9" />
        <img class="image-item" src="https://www.codingnepalweb.com/demos/responsive-image-slider-html-css-javascript/images/img-10.jpg" alt="img-10" />
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


@role('customer') @if ($server == '"Android"')
<div  class="container-fluid mt-1">
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
@endrole 

@endif
@endsection
