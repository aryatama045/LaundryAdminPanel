@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row h-100vh align-items-center">
            <div class="col-md-10 col-lg-9 col-sm-12 m-auto">
                <form action="{{ route('stripeKey.update') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary py-2">
                            <h3 class="text-white m-0">{{ __('Stripe payment key set') }}</h3>
                        </div>
                        <div class="card-body pb-3">
                            <div class="mb-2">
                                <label class="mb-1 text-dark">{{ __('Stripe Public Key') }} <span class="text-danger">*</span></label>
                                <textarea name="public_key" class="form-control" rows="2" placeholder="{{ __('Stripe Public Key') }}">
                                    {{ config('app.stripe_key') }}
                                </textarea>
                                @error('public_key')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="mb-1 text-dark">{{ __('Stripe Secret Key') }} <span class="text-danger">*</span></label>
                                <textarea name="secret_key" class="form-control" rows="2" placeholder="{{ __('Stripe Secret Key') }}">
                                    {{ config('app.stripe_secret') }}
                                </textarea>
                                @error('secret_key')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer py-3 ">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary rounded-0 @role('visitor') visitorMessage @endrole">{{ __('Save And Update') }}</button>
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
    $('textarea').each(function(){
            $(this).val($(this).val().trim());
        }
    );
</script>
@endpush

