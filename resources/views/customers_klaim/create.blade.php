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
                            <h2 class="float-left">{{ __('Add_New'). ' '. __('Klaims') }}</h2>
                            <div class="text-right">
                                <a class="btn btn-light" href="{{ route('klaim.index') }}"> {{ __('Back') }} </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('klaim.store') }}" method="POST" enctype="multipart/form-data"> @csrf
                            <div class="row">

                                @role('root')
                                <!-- Select Customer -->
                                <div class="col-12 col-md-12 mb-2">
                                    <label for="">{{ __('Select Customer') }} <strong class="text-danger">*</strong> </label>
                                    <select class="form-control" name="customer_id" id="customer_id" required>
                                        <option value=""> -- Select Customers --</option>
                                        @foreach ($customer as $customers)
                                            <option value="{{ $customers->id }}"> {{ $customers->id.'-'.$customers->user->first_name.' '.$customers->user->last_name }}  </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endrole

                                @role('customer')

                                    @php
                                        $user_id = auth()->user()->id;
                                        $customer = \App\Models\Customer::where('user_id',$user_id )->first();
                                    @endphp

                                    <input hidden name="customer_id" value="{{ $customer->id }}" />

                                @endrole

                                <!-- No Validasi -->
                                <div class="col-12 col-md-6 mb-2">
                                    <label for=""><b>{{ __('Nomor Validasi') }}</b> <strong class="text-danger">*</strong></label>
                                    <div class="input-group typeahead-container">
                                        <input id="no_validasi" name="no_validasi" type="email" class="form-control typeahead" placeholder="Nomor Validasi" autocomplete="off" required="">
                                        <div class="input-group-append">
                                            <a href="#" class="btn btn-primary default">
                                                <i class="simple-icon-magnifier"></i> Check
                                            </a>
                                        </div>
                                        <span class="mt-2" id="hasil_validasi"></span>
                                    </div>
                                    @error('no_validasi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- No Seri -->
                                <div class="col-12 col-md-6 mb-2">
                                    <label for=""><b>{{ __('Nomor Seri/Barcode') }}</b> <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="no_seri"
                                        value="{{ old('no_seri') }}" placeholder="{{ __('Nomor Seri/Barcode') }}">
                                    @error('no_seri')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nota -->
                                <div class="col-12 col-md-6 mb-2">
                                    <label for=""><b>{{ __('No. Nota') }}</b> <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control" name="no_nota"
                                        value="{{ old('no_nota') }}" placeholder="{{ __('No. Nota') }}">
                                    @error('no_nota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label for=""><b>{{ __('Tanggal Nota') }}</b> <strong class="text-danger">*</strong></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal_nota" value="{{ now()->toDateString('d/m/Y') }}" >
                                    @error('tanggal_nota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Pemasangan -->
                                <div class="col-12 col-md-6 mb-2">
                                    <label for=""><b>{{ __('Tanggal & Waktu Pemasangan') }} </b><strong class="text-danger">*</strong></label>
                                    <input type="datetime-local" class="form-control" id="tanggal" name="waktu_pemasangan"
                                        value="{{ old('waktu_pemasangan') }}" placeholder="{{ __('Waktu Pemasangan') }}">
                                    @error('waktu_pemasangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-12 col-md-8 mb-2">
                                    <label><b>{{ __('Bukti Foto') }}</b> </label>
                                    <span name="add" class="float-right btn btn-primary btn-sm default add">
                                        <i class="fa fa-plus"></i> Tambah
                                    </span>

                                    <div class="item_table mt-3" id="item_table">
                                        <div class="input-group input-group-sm mb-3" id="dtTgl">
                                            <input style="height:100% !important" type="file" multiple="" class="form-control" name="klaim_photo[]"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            <!-- <div class="input-group-append"><span style="height:100% !important" name="add" class="btn btn-primary default add" id="inputGroup-sizing-sm"><i class="fa fa-plus"></i> Tambah</span></div> -->
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

    <script type="text/javascript">
        var url = '{!! url() !!}';
        $(document).ready(function() {
            $("#no_validasi").change(function() {
                var customer_id = $("#customer_id").val();
                var nomor_val = $("#no_validasi").val();
                //cek jika nomor_val kosong
                if (nomor_val != "") {
                    $.post('{{ route('klaim.check_validasi') }}', {
                        _token: '{{ @csrf_token() }}',
                        nomor_val: nomor_val,
                        customer_id : customer_id
                        }, function(data) {
                            $("#hasil_validasi").html(data);
                        }
                    );
                }
            });

            

        });

        $(document).ready(function() {

            var count = 1;

            function add_input_field(count) {

                var html = '';

                if (count > 1) {

                    html += ' <div class="input-group input-group-sm mb-3" id="dtTgl">'+
                        '<input style="height:100% !important" type="file" multiple="" class="form-control" name="klaim_photo[]" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">';
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
