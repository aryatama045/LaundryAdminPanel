@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <h3 class="card-title m-0">{{ __('Edit') }} {{ $user->name }} {{ __('information') }}</h3>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form @role('visitor') action="#" @else action="{{ route('admin.update', $user->id) }}" @endrole method="POST"> @csrf @method('put')
                            <div class="row">
                                <input type="hidden" name="userId" value="{{ $user->id }}">
                                <div class="col-6">
                                    <label for="">{{ __('First_Name') }}</label>
                                    <x-input type="text" name="first_name" :value="$user->first_name"
                                        placeholder="{{ __('First_Name') }}" />
                                </div>

                                <div class="col-6">
                                    <label for="">{{ __('Last_Name') }}</label>
                                    <x-input type="text" name="last_name" :value="$user->last_name"
                                        placeholder="{{ __('Last_Name') }}" />
                                </div>

                                <div class="col-6">
                                    <label for="">{{ __('Email') }}</label>
                                    <x-input type="email" name="email" :value="$user->email"
                                        placeholder="{{ __('Email') }}" />
                                </div>

                                <div class="col-6">
                                    <label for="">{{ __('Gender') }}</label>
                                    <x-select name="gender">
                                        @foreach (config('enums.ganders') as $gender)
                                            <option value="{{ $gender }}"
                                                {{ $user->gender == $gender ? 'selected' : '' }}>{{ __($gender) }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>

                                <div class="col-6">
                                    <label for="">{{ __('Phone_number') }}</label>
                                    <x-input type="number" name="mobile" :value="$user->mobile"
                                        placeholder="{{ __('Phone_number') }}" />
                                </div>

                                <div class="col-6">
                                    <label for="">{{ __('Password') }}</label>
                                    <x-input type="text" name="password" placeholder="{{ __('Password') }}" />
                                </div>

                                <div class="col-6">
                                    <label for="">{{ __('Confirm_Password') }}</label>
                                    <x-input type="text" name="password_confirmation"
                                        placeholder="{{ __('Confirm_Password') }}" />
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="" class="mb-1"></label>
                                    <button type="submit" class="btn mt-1 btn-primary w-100 @role('visitor') visitorMessage @endrole">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </form>
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
            if (!(/[0-9]/.test(chars))) {
                evt.preventDefault();
            }
        }
    </script>
@endpush
