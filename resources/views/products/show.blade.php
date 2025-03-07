@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0 mt-2 mt-sm-0 d-flex">
                <a href="{{ route('product.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title m-0">{{ __('Edit'). ' '.__('Product') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img width="50%" src="{{ $product->thumbnailPath }}" alt="">
                        </div>

                            <label class="mb-1">{{ __('Product').' '.__('Name').' '.__('English')}}</label>
                            <x-input name="name" type='text' placeholder="{{ __('Product').' '.__('Name').' '.__('English')}}"
                                value="{{ old('name') ?? $product->name }}"/>

                            <label class="mb-1">{{ __('Product').' '.__('Price') }}</label>
                            <input name="price" type='text' class="form-control" placeholder="{{ __('Product').' '.__('Price') }}"
                                value="{{ old('price') ?? $product->price }}" onkeypress="onlyNumber(event)"/>
                            @error('price')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror

                            <label class="mb-1 mt-3">{{ __('Discount').' '.__('Price') }}</label>
                            <input name="discount_price" type='text' class="form-control" placeholder="{{ __('Discount').' '.__('Price') }}"
                                value="{{ old('discount_price') ?? $product->discount_price }}" onkeypress="onlyNumber(event)"/>
                            @error('discount_price')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror

                            <label class="mb-1 mt-3">{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="{{ __('Description') }}">{{$product->description}}</textarea>

                            <input type="hidden" id="slug" name="slug" class="form-control input-default"
                                value="{{ old('slug') ?? $product->slug }}">

                                <label class="mb-1 mt-3">{{ __('Select').' '.__('Service') }}</label>
                            <x-select name="service_id">
                                <option value="">{{ __('Select') }}</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ $product->service_id == $service->id ? 'selected' : '' }}>
                                        {{ session()->get('local') == 'ar' ? $service->name_bn ?? $service->name : $service->name }}
                                    </option>
                                @endforeach
                            </x-select>

                            <label class="mb-1">{{ __('Select').' '.__('Variant') }}</label>
                            <x-select name="variant_id">
                                @foreach ($variants as $variant)
                                    <option {{ $product->variant_id == $variant->id ? 'selected' : '' }}
                                        value="{{ $variant->id }}">
                                        {{ session()->get('local') == 'ar' ? $variant->name_bn ?? $variant->name : $variant->name }}
                                    </option>
                                @endforeach
                            </x-select>

                            <label class="mb-1">{{ __('Product').' '.__('Photo') }}</label>
                            <x-input-file name="image" type="file"/>

                            <div class="form-group">
                                <label for="active" class="mr-2">
                                    <input type="radio" id="active" name="active"
                                        {{ $product->is_active ? 'checked' : '' }} value="1"> {{ __('Active') }}
                                </label>

                                <label for="in_active">
                                    <input type="radio" id="in_active" name="active"
                                        {{ !$product->is_active ? 'checked' : '' }} value="0"> {{ __('Inactive') }}
                                </label>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function onlyNumber(evt) {
            var chars = String.fromCharCode(evt.which);
            if (!(/[0-9.]/.test(chars))) {
                evt.preventDefault();
            }
        }

        $('#name').keyup(function() {
            $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g, "-"));
        });

        $('select[name="service_id"]').on('change', function() {
            var serviceId = $(this).val();
            if (serviceId) {
                $.ajax({
                    url: `/services/${serviceId}/variants`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="variant_id"]').empty();
                        var local = '{{ session()->get('local') }}';
                        $.each(data, function(key, value) {
                               $('select[name="variant_id"]').append('<option value="'+value.id+'">'+ (local == 'ar' ? (value.name_bn ?value.name_bn : value.name) : value.name) +'</option>');
                        });
                    }
                });
            } else {
                $('select[name="variant_id"]').empty();
            }
        });
    </script>
@endpush
