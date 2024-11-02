@extends('layouts.app')

@section('content')




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
                @if ($server == '"Windows"')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Garansi ')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">
                                        0
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
                                        0
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


@role('customer') @if ($server == '"Android"')
<div  class="container-fluid mt-4">
    <div class="row">

        
        <div class="col-12 col-lg-4">
            <div class="card" style="border-radius: 10px; border-bottom: 4px solid var(--theme-color);">
                <div class="overview">
                    <img width="100%" src="{{ asset('web/bg/overview.svg') }}" alt="">
                    <div>
                        <h2 class="text-white">{{ __('Overview') }}</h2>
                    </div>
                </div>

                @role('admin')
                <div class="row p-3">
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/users.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $customers->count() }}</h3>
                            <span class="txt-1">{{ __('Users') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/Orders.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $confirmOrder }}</h3>
                            <span class="txt-1">{{ __('Orders') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/Pending.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $pendingOrder }}</h3>
                            <span class="txt-1">{{ __('Pending') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/progress.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{  $onPregressOrder }}</h3>
                            <span class="txt-1">{{ __('On_progress') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4">
                        <img width="50" src="{{ asset('images/icons/delivered.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $completeOrder }}</h3>
                            <span class="txt-1">{{ __('Delivered') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 ">
                        <img width="50" src="{{ asset('images/icons/order.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $cancelledOrder }}</h3>
                            <span class="txt-1">{{ __('Cancel_Order') }}</span>
                        </div>
                    </div>
                </div>
                @endrole

                <div class="row p-3">
                    
                    <div class="col-lg-6 col-4">
                        <img width="50" src="{{ asset('images/icons/delivered.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">00</h3>
                            <span class="txt-1">{{ __('Garansi') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4">
                        <img width="50" src="{{ asset('images/icons/delivered.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">00</h3>
                            <span class="txt-1">{{ __('Klaim') }}</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        

    </div>
</div>
@endrole @endif
@endsection
