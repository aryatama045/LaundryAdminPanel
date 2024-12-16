@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">{{ __('Edit'). ' '. __('Customer') }}</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ route('customer.index') }}"> {{ __('Back') }} </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('garansi.update', $order->id) }}" method="POST" enctype="multipart/form-data"> @csrf
                        @method('put')
                        <div class="row">
                            <!-- No Seri -->
                            <div class="col-12 col-md-12 mb-2">
                                <label for=""><b>{{ __('Nomor Seri/Barcode') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" value="{{ $garansi->no_seri }}" readonly>
                                @error('no_seri')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- No Validasi -->
                            <div class="col-12 col-md-12 mb-2">
                                <label for=""><b>{{ __('Nomor Validasi') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" value="{{ $garansi->no_validasi }}" readonly>
                                @error('no_validasi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nota -->
                            <div class="col-12 col-md-6 mb-2">
                                <label for=""><b>{{ __('No. Nota') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" value="{{ $garansi->no_nota }}" readonly>
                                @error('no_nota')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for=""><b>{{ __('Tanggal Nota') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal_nota" value="{{ $garansi->tanggal_nota }}" readonly>
                                @error('tanggal_nota')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Pemasangan -->
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">{{ __('Tanggal & Waktu Pemasangan') }} <strong class="text-danger">*</strong></label>
                                <input type="datetime-local" class="form-control" id="tanggal" name="waktu_pemasangan"
                                    value="{{ $garansi->waktu_garansi }}" >
                                @error('waktu_pemasangan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-6">
                            <button class="float-left btn btn-primary">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
