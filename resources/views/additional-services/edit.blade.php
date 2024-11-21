@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="col-sm-6 p-md-0  mt-2 mt-sm-0 d-flex">
            <a href="{{ route('additional.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
        </div>

        <div class="row">
            <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Edit').' '.__('Additional_Service') }}</h4>
                    </div>
                    <div class="card-body">
                        <x-form route="additional.update" updateId="{{ $additional->id }}" type="Submit" method="true">
                            <x-input name="title" type='text' placeholder="{{ __('Title') }} " value="{{ $additional->title }}" />
                            <x-input name="price" placeholder="{{ __('Price') }}" value="{{ $additional->price }}" type="text" />

                            <x-textarea name="description" placeholder="{{ __('Description') }}" value="{{ $additional->description }}" />
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
