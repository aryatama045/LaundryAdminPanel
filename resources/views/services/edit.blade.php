@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="col-sm-6 p-md-0  mt-2 mt-sm-0 d-flex">
            <a href="{{ route('service.index') }}" class="btn btn-primary mb-1"><i class="fa fa-arrow-left"></i>
                {{ __('Back') }}</a>
        </div>

        <div class="row">
            <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Edit') . ' ' . __('Service') }}</h4>
                    </div>
                    <div class="card-body">
                        <x-form route="service.update" updateId="{{ $service->id }}" type="Submit" method="true">
                            <div class="form-group text-center">
                                <img width="50%" src="{{ $service->thumbnailPath }}" alt="">
                            </div>

                            <label>{{ __('Name') . ' ' . __('of') . ' ' . __('English') }}</label>
                            <x-input name="name" type="text"
                                placeholder="{{ __('Service') . ' ' . __('Name') . ' ' . __('English') }}"
                                value="{{ $service->name }}" />

                            <label>{{ __('Name') . ' ' . __('of') . ' ' . __('Arabic') }}</label>
                            <x-input name="name_bn" type='text' value="{{ $service->name_bn }}"
                                placeholder="{{ __('Service') . ' ' . __('Name') . ' ' . __('Arabic') }}" />

                            <label for="">Selected Variants</label>
                            <x-select :multi="true" name="variant_ids[]">
                                @foreach ($variants as $variant)
                                    <option value="{{ $variant->id }}"
                                        {{ in_array($variant->id, $service->variants->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ session()->get('local') == 'ar' ? $variant->name_bn ?? $variant->name : $variant->name }}
                                    </option>
                                @endforeach
                            </x-select>

                            <label>{{ __('Service') . ' ' . __('Photo') }}</label>
                            <x-input-file name="image" type="file" />

                            <label>{{ __('Service') . ' ' . __('Description') }}</label>
                            <x-textarea name="description" placeholder="{{ __('Service') . ' ' . __('Description') }}"
                                value="{{ $service->description }}" />

                            <label>{{ __('Additional_Service') }}</label>
                            <x-select :multi="true" name="additional[]">
                                @foreach ($additionals as $additional)
                                    <option value="{{ $additional->id }}"
                                        {{ in_array($additional->id, $service->additionals->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $additional->title }}
                                        {{ session()->get('local') == 'ar' ? $additional->title_bn ?? $additional->title : $additional->title }}
                                    </option>
                                @endforeach
                            </x-select>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#name').keyup(function() {
            $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g, "-"));
        });
    </script>
@endpush
