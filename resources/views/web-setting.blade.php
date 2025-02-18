@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row align-items-center" style="min-height: 80vh">
            <div class="col-md-10 col-lg-9 col-sm-12 m-auto">
                <form action="{{ route('webSetting.update', $websetting?->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary py-2">
                            <h3 class="text-white m-0">{{ __('Web Settings') }}</h3>
                        </div>
                        <div class="card-body pb-3">
                            <div class="row">
                                <div class="col-md-6 border-right">
                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Website Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $websetting?->name }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Website title') }}</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $websetting?->title }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Logo') }}</label>
                                        <input type="file" name="logo" class="form-control-file" accept="image/*"
                                            onchange="previewLogoFile(event)">
                                        <img src="{{ $websetting?->websiteLogoPath }}" alt="" id="logoPreview"
                                            width="80">
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Time Zone') }}</label>
                                        <select name="timezone" class="form-control">
                                            @foreach ($zones as $zone)
                                                <option {{ $zone['zone'] == config('app.timezone') ? 'selected' : '' }}
                                                    value="{{ $zone['zone'] }}">
                                                    {{ $zone['diff_from_GMT'] . ' - ' . $zone['zone'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('City') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control"
                                            value="{{ $websetting?->city }}" required>
                                    </div>
                                    <div class="">
                                        <label class="mb-0 text-dark">{{ __('Invoice Signature') }}</label>
                                        <input type="file" name="signature" class="form-control-file" accept="image/*"
                                            onchange="previewSignature(event)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('favicon') }}</label>
                                        <input type="file" name="fav_icon" class="form-control-file" accept="image/*"
                                            onchange="previewFavIco(event)">
                                        <img src="{{ $websetting?->websiteFaviconPath }}" alt="" id="favionPreview"
                                            width="60">
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Address') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" rows="2" required>{{ $websetting?->address }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="mb-0 text-dark"><b>WA Number</b></label>
                                        <input type="text" name="mobile" class="form-control"
                                            value="{{ $websetting?->mobile }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="mb-0 text-dark"><b>Default Masa Berlaku /hari</b></label>
                                        <input type="text" name="masa_berlaku" class="form-control"
                                            value="{{ $websetting?->masa_berlaku }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Currency Symbol') }}</label>
                                        <input type="text" name="currency" class="form-control"
                                            value="{{ $websetting?->currency }}" placeholder="exm: $" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="mb-0 text-dark">{{ __('Currency Position') }}</label>
                                        <select name="currency_position" class="form-control">
                                            <option {{ config('app.currency_position') == 'Prefix' ? 'selected' : '' }} value="Prefix">
                                                {{ __('Prefix') }}
                                            </option>
                                            <option {{ config('app.currency_position') == 'Suffix' ? 'selected' : '' }} value="Suffix">
                                                {{ __('Suffix') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <img src="{{ $websetting?->signaturePath }}" alt="" id="signaturePreview"
                                            width="80"> <small>{{ __('signature') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-3 ">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary rounded-0">{{ __('Save And Update') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var previewLogoFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('logoPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        var previewFavIco = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('favionPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        var previewSignature = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('signaturePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
