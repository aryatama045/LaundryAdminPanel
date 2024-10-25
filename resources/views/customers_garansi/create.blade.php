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
                                    <label for="">{{ __('Customer') }} <strong class="text-danger">*</strong> </label>

                                    <select class="form-control" name="customer_id" required>
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
                                    <label for="">{{ __('No. Nota') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="no_nota"
                                        value="{{ old('no_nota') }}" placeholder="{{ __('No. Nota') }}">
                                    @error('no_nota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Tanggal Nota') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="tanggal_nota"
                                        value="{{ old('tanggal_nota') }}" placeholder="{{ __('Tanggal Nota') }}">
                                    @error('tanggal_nota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('No. Pemasangan') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="no_pemasangan"
                                        value="{{ old('no_pemasangan') }}" placeholder="{{ __('No. Pemasangan') }}">
                                    @error('no_pemasangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for="">{{ __('Tanggal Pemasangan') }} <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="tanggal_pemasangan"
                                        value="{{ old('tanggal_pemasangan') }}" placeholder="{{ __('Tanggal Pemasangan') }}">
                                    @error('tanggal_pemasangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-12 mb-2">
                                    <label for="">{{ __('Keterangan') }} </label>
                                    <input type="text" class="form-control" name="keterangan"
                                        value="{{ old('keterangan') }}" placeholder="{{ __('Keterangan') }}">
                                    @error('keterangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-2 py-2">
                                    <label for="">{{ __('Profile_Photo') }}</label>
                                    <input type="file" class="form-control-file" name="garansi_photo">
                                </div>

                                <div class="row">
                                    <div class="col-3 col-md-3 mt-4 mb-2 py-2">
                                        <label for=""></label>
                                        <button class="btn btn-primary w-100 mt-2  ">{{ __('Submit') }}</button>
                                    </div>
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
