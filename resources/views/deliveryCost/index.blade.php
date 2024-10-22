@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 m-auto">
                <div class="card">
                    <div class="card-header bg-primary py-2">
                       <h3 class="m-0 text-white"> {{ __('Delivery Cost Price') }}</h3>
                    </div>
                    <form action="{{ route('deliveryCost') }}" method="post">
                        @csrf
                        <div class="card-body">
                            @php
                                $websetting = App\Models\WebSetting::first();
                                $currency = $websetting->currency ?? config('enums.currency')
                            @endphp
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="m-0">{{ __('Delivery Charge') }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{$currency}}</span>
                                        </div>
                                        <input type="number" class="form-control" name="cost"
                                            value="{{ $cost ? $cost->cost : 0 }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="m-0">{{ __('Fee Delivery') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{$currency}}</span>
                                        </div>
                                        <input type="number" class="form-control" name="fee_cost"
                                            value="{{ $cost ? $cost->fee_cost : 100 }}" required>
                                    </div>
                                    <small class="text-gray">{{ __('Default delivery fee') }} 100 </small>
                                </div>

                                <div class="col-sm-4">
                                    <label class="m-0">{{ __('Minimum order amount') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{$currency}}</span>
                                        </div>
                                        <input type="number" class="form-control" name="minimum_cost"
                                            value="{{ $cost ? $cost->minimum_cost : 00 }}" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer py-2">
                            <button type="submit" class="btn btn-primary px-4">{{ __('Save And Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
