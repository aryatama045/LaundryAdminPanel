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
                            <!-- nama_barang -->
                            <div class="col-12 col-md-6 mb-4">
                                <label for=""><b>{{ __('Nama Barang') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="nama_barang" value="{{ $order->nama_barang }}" readonly>
                                @error('nama_barang')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Qty -->
                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <label for=""><b>{{ __('Qty') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="number" class="form-control" id="qty" name="qty" min="1" max="{{ $order->qty }}"
                                        value="{{ $order->qty }}" >
                                <a href="#" class="text-success mt-1" data-toggle="tooltip" title="Qty tidak boleh lebih dari yang tertera pada nota.">
                                    (?)Cara Pengisian Qty?</a>
                                @error('qty')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Pemasangan -->
                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <label for=""><b>{{ __('Tanggal & Waktu Pemasangan') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="datetime-local" class="form-control" id="tanggal" name="waktu_pemasangan"
                                    value="{{ $garansi?->waktu_garansi }}" >
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

@push('scripts')
    <script>
        document.getElementById("qty").addEventListener("change", function() {
            let v = parseInt(this.value);
            if (v < 1) this.value = 1;
            if (1 > v) this.value = v;
        });
    </script>
@endpush
