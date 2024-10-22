@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="col-sm-6 p-md-0 mt-2 mt-sm-0 d-flex">
        <a href="{{ route('service.index') }}" class="btn btn-primary mb-1"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
    </div>

    <div class="row">
        <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Add') . ' '. __('Service') }}</h4>
                </div>
                <div class="card-body">
                    <x-form route="service.store" type="Submit">
                        <label>{{ __('Name').' '.__('of'). ' '. __('English') }}</label>
                        <x-input name="name" type='text' placeholder="{{ __('Service').' '.__('Name'). ' '. __('English') }}"/>

                        <label>{{ __('Name').' '.__('of'). ' '. __('Arabic') }}</label>
                        <x-input name="name_bn" type='text' placeholder="{{ __('Service').' '.__('Name'). ' '. __('Arabic') }}"/>

                        <label>{{ __('Select').' '.__('Variants') }}</label>
                        <x-select :multi="true" name="variant_ids[]">
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}">{{ session()->get('local') == 'ar' ? ($variant->name_bn ??$variant->name) : $variant->name}}</option>
                            @endforeach
                        </x-select>

                        <label>{{ __('Service').' '.__('Photo') }}</label>
                        <x-input-file name="image" type="file"/>

                        <label>{{ __('Service').' '.__('Description') }}</label>
                        <x-textarea name="description" placeholder="{{ __('Service').' '.__('Description') }}" />

                    </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
