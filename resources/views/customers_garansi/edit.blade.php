@extends('layouts.app')

@section('content')


<style>
    input#tanggal {
        display: inline-block;
        position: relative;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">{{ __('Tambah'). ' '. __('Proteksi') }} - {{ $order->nama_barang }}</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ route('garansi.index') }}"> {{ __('Back') }} </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fileUploadForm" action="{{ route('garansi.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('put')
                        <div class="row">
                            <!-- nomor_nota -->
                            <div class="col-12 col-md-6 mb-4">
                                <label for=""><b>{{ __('Nomor Nota') }}</b> <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="nomor_nota" value="{{ $order->nomor_nota }}" readonly>
                                @error('nomor_nota')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

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
                                        value="{{ $order->qty }}" onkeyup=imposeMinMax(this)>
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
                                <input type="datetime-local" class="form-control" id="tanggal" required  name="waktu_pemasangan"
                                    value="{{ $garansi?->waktu_garansi }}" >
                                @error('waktu_pemasangan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12 col-md-8 mb-2">
                                <label><b>{{ __('Bukti Foto') }}</b> </label>
                                <span hidden name="add" class="float-right btn btn-primary btn-sm default add">
                                    <i class="fa fa-plus"></i> Tambah
                                </span>

                                <div class="item_table mt-3" id="item_table">
                                    <div class="input-group input-group-sm mb-3" id="dtTgl">
                                        <input style="height:100% !important" type="file" multiple="" class="form-control" name="garansi_photo[]" >
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 col-md-8 mb-2">
                                <label><b>{{ __('Bukti Video') }}</b> </label>

                                <div class=" mt-3"  >
                                    <div class="input-group input-group-sm mb-3" >
                                        <input style="height:100% !important" type="file" class="form-control" name="garansi_video"   >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#fileUploadForm').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete: function (xhr) {
                        // alert('File has uploaded successfully!'); 
                        Swal.fire({
                            title: 'File has uploaded successfully!',
                            type: 'success',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#00B894',
                            // cancelButtonColor: '#d33',
                            // confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = url;
                            }
                        })
                        // window.location.href = "{{ route('garansi.index')}}";
                    }
                });
            });
        });
    </script>

    <script>
        function imposeMinMax(el){
            if(el.value != ""){
                if(parseInt(el.value) < parseInt(el.min)){
                    el.value = el.min;
                    Swal.fire({
                        title: 'Qty Tidak Boleh Kurang, dari nilai nota',
                        type: 'warning',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00B894',
                        // cancelButtonColor: '#d33',
                        // confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    })
                }
                if(parseInt(el.value) > parseInt(el.max)){
                    el.value = el.max;
                    Swal.fire({
                        title: 'Qty Tidak Boleh Lebih, dari nilai nota',
                        type: 'warning',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00B894',
                        // cancelButtonColor: '#d33',
                        // confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    })
                }
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            var count = 1;

            function add_input_field(count) {

                var html = '';

                if (count > 1) {

                    html += ' <div class="input-group input-group-sm mb-3" id="dtTgl">'+
                        '<input style="height:100% !important" type="file" accept="image/*" multiple="" class="form-control" name="garansi_photo[]" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">';
                }
                var remove_button = '';

                if (count > 1) {
                    remove_button = '<div class="input-group-append"><span style="height:100% !important" name="remove" class="btn btn-danger default remove" id="inputGroup-sizing-sm"><i class="fa fa-trash"></i>  Hapus</span></div>';
                }

                html += remove_button +
                            '</div>';

                return html;

            }

            $('#item_table').prepend(add_input_field(1));


            $(document).on('click', '.add', function() {
                count++;
                $('#item_table').prepend(add_input_field(count));
            });

            $(document).on('click', '.remove', function() {
                const element = document.getElementById("dtTgl");
                element.remove();
                // $(this).closest('tr').remove();
            });


        });
    </script>

@endpush
