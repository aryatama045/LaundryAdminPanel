@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="col-sm-6 p-md-0 mt-2 mt-sm-0 d-flex">
        <a href="{{ route('additional.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
    </div>

    <div class="row">
        <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Create').' '.__('Additional_Service') }}</h4>
                </div>
                <div class="card-body">
                    <x-form route="additional.store" type="Submit">
                        <x-input name="title" placeholder="{{ __('Title') }} {{ __('English') }}" type='text'/>
                        <x-input name="title_bn" type="text" placeholder="{{ __('Title').' '.__('Arabic').' '.__('Name') }}" />
                        <x-input name="price" placeholder="{{ __('Price') }}" type="number" />

                        <x-textarea name="description" placeholder="{{ __('Description').' '.__('English') }}" />
                        <x-textarea name="description_bn" placeholder="{{ __('Description').' '.__('Arabic') }}" />
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
