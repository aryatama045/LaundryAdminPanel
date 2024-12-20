@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-6">
                            <h2 class="card-title"></h2>
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
                        <form @role('root|admin') @can('coupon.update') action="{{ route('coupon.update', $coupon->id) }}" @endcan @endrole method="POST"> @csrf @method('put')
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="mb-1">{{  '.__('Code') }}</label>
                                    <x-input name="code" type="text" value="{{ $coupon->code }}" placeholder="code"/>
                                </div>

                                <!-- <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ __('Select').' '.__('Discount_Type') }}</label>
                                    <select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
                                        <option value="">{{ __('Select').' '.__('Discount_Type') }}</option>
                                        @foreach (config('enums.coupons.discount_types') as $discountType)
                                        <option value="{{ $discountType }}" {{ $coupon->discount_type == $discountType ? 'selected' : ''}}>{{ __($discountType) }}</option>
                                        @endforeach
                                    </select>
                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ __('Discount') }}</label>
                                    <x-input name="discount" type="text" value="{{ $coupon->discount }}" placeholder="Discount"/>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="mb-1">{{ __('Minimum_Amount') }}</label>
                                    <x-input name="min_amount" type="text" value="{{ $coupon->min_amount }}" placeholder="Minimum Amount"/>
                                </div>

                                <div class="col-12">
                                    <label for="">{{ __('Started_at') }}</label>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <x-input type="date" value="{{ Carbon\Carbon::parse($coupon->started_at)->format('Y-m-d') }}" name="start_date"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <x-input type="time" value="{{ Carbon\Carbon::parse($coupon->started_at)->format('H:i') }}" name="start_time"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="">{{ __('Expired_at') }}</label>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <x-input type="date" value="{{ Carbon\Carbon::parse($coupon->expired_at)->format('Y-m-d') }}" name="expired_date"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <x-input type="time" value="{{ Carbon\Carbon::parse($coupon->expired_at)->format('H:i') }}" name="expired_time"/>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-12">
                                    <div class="row">
                                        <!-- <div class="col-12 col-md-6">
                                            <label for="yes">
                                                <input type="radio" id="yes" name="notify" value="1"> {{ __('Notify_All_Customer') }}.
                                            </label>
                                            <label for="no" class="ml-3">
                                                <input type="radio" id="no" name="notify" value="0"> {{ __('not_need') }}
                                            </label>
                                        </div> -->
                                        @can('coupon.update')
                                        <div class="col-12 col-md-6 text-right">
                                            <button type="submit" class="btn btn-primary px-5 @role('visitor') visitorMessage @endrole">{{ __('Update') }}</button>
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
