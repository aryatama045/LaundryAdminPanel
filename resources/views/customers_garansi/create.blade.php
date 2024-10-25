@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="w-100">
                            <h2 class="float-left">{{ __('Add_New'). ' '. __('Customer') }}</h2>
                            <div class="text-right">
                                <a class="btn btn-light" href="{{ route('customer.index') }}"> {{ __('Back') }} </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @role('root|admin') @can('customer.store') action="{{ route('customer.store') }}" @endcan @endrole method="POST" enctype="multipart/form-data"> @csrf
                            <div class="row">
                                <!-- Select Customer -->
                                <div class="col-12 col-md-12 mb-2">
                                    <label for="">{{ __('Customer') }} </label>

                                    <select class="form-control"  name="customer_id" >
                                        <option value=""> -- Select Customers --</option>

                                        @foreach ($customer as $customers)
                                            <option value="{{ $customers->customer_id }}"> {{ $customers->user->first_name.' '.$customers->user->last_name }}  </option>
                                        @endforeach
                                    </select>


                                    @error('customer_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('First_Name') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name') }}" placeholder="{{ __('First_Name') }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Last_Name') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}" placeholder="{{ __('Last_Name') }}">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-12 mb-2">
                                    <label for="">{{ __('Company') }} </label>
                                    <input type="text" class="form-control" name="company"
                                        value="{{ old('company') }}" placeholder="{{ __('Company') }}">
                                    @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Mobile_number') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                        placeholder="{{ __('Mobile_number') }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Email') }}</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                        placeholder="{{ __('Email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Password') }} <strong class="text-danger">*</strong></label>
                                    <div class="d-flex  align-items-center inputBox">
                                        <div class="input w-100 position-relative">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="******">
                                            <span class="eye" onclick="myFunction()">
                                                <i class="fa fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Confirm_Password') }}</label>
                                    <div class="d-flex  align-items-center inputBox">
                                        <div class="input w-100 position-relative">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="******" id="confirmPassword">
                                            <span class="eye" onclick="confirmPassword()">
                                                <i class="fa fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2 py-2">
                                    <label for="">{{ __('Profile_Photo') }}</label>
                                    <input type="file" class="form-control-file" name="profile_photo">
                                </div>

                                @can('customer.store')
                                <div class="col-12 col-md-6 mb-2 py-2">
                                    <label for=""></label>
                                    <button class="btn btn-primary w-100 mt-2  @role('visitor') visitorMessage @endrole">{{ __('Submit') }}</button>
                                    @endcan
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .eye {
            position: absolute;
            right: 8px;
            top: 11px;
            cursor: pointer;
        }
    </style>
@endsection
@push('scripts')
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function confirmPassword() {
            var x = document.getElementById("confirmPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endpush
