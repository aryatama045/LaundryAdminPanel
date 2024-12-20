@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                            <div class="col-6">
                                <h2 class="card-title">{{ __('Create'). '  }}</h2>
                            </div>

                            <div class="col-6 position-relative" >
                                <div class="position-absolute" style="right: 1em" >
                                    <a href="{{ route('coupon.index') }}" class="btn btn-dark"><i class="fa fa-arrow-left"></i>  {{ __('Back') }}</a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-8 m-auto">
                        <form @can('coupon.store') @role('root|admin') action="{{ route('coupon.store') }}" @endrole @endcan method="POST"> @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ '.__('Code') }}</label>
                                    <x-input name="code" type="text" placeholder="{{ '.__('Code') }}"/>
                                </div>

                                <!-- <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ __('Select').' '.__('Discount_Type') }}</label>
                                    <select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
                                        <option value="">{{ __('Select').' '.__('Discount_Type') }}</option>
                                        @foreach (config('enums.coupons.discount_types') as $discountType)
                                        <option value="{{ $discountType }}">{{ __($discountType) }}</option>
                                        @endforeach
                                    </select>
                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ __('Discount') }}</label>
                                    <x-input name="discount" type="text" placeholder="{{ __('Discount') }}"/>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ __('Minimum_Amount') }}</label>
                                    <x-input name="min_amount" type="text" placeholder="{{ __('Minimum_Amount') }}"/>
                                </div>

                                <div class="col-12">
                                    <label for="">{{ __('Started_at') }}</label>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <x-input type="date" name="start_date"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <x-input type="time" name="start_time"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="">{{ __('Expired_at') }}</label>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <x-input type="date" name="expired_date"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <x-input type="time" name="expired_time"/>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-12">
                                    <div class="row">
                                        <!-- <div class="col-12 col-md-6">
                                            <label for="yes">
                                                <input type="radio" id="yes" name="notify" value="0"> {{ __('Notify_All_Customer') }}.
                                            </label>
                                            <label for="no" class="ml-3">
                                                <input type="radio" id="no" name="notify" value="1"> {{ __('not_need') }}
                                            </label>
                                        </div> -->
                                        @can('coupon.store')
                                        <div class="col-12 col-md-6 text-right">
                                            <button type="submit" class="btn btn-primary px-5 @role('visitor') visitorMessage @endrole">{{ __('Submit') }}</button>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
