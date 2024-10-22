@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 m-auto">
                <form action="{{ route('mobileApp') }}" method="post">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary py-2">
                            <h3 class="m-0 text-white">{{ __('Mobile App Link') }}</h3>
                        </div>
                        @csrf
                        <div class="card-body">
                            <label class="m-0">{{ __('Android Url') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" name="android_url" class="form-control" placeholder="{{ __('Android Url') }}"
                                    value="{{ $appLink ? $appLink->android_url : '' }}">
                            </div>

                            <label class="m-0">{{ __('IOS Url') }}</label>
                            <div class="input-group">
                                <input type="text" name="ios_url" class="form-control" placeholder="{{ __('IOS Url') }}"
                                    value="{{ $appLink ? $appLink->ios_url : '' }}">
                            </div>
                        </div>
                        <div class="card-footer py-2">
                            <button type="submit" class="btn btn-primary px-4 @role('visitor') visitorMessage @endrole">{{ __('Save And Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
