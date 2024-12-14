@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center py-2 justify-content-between">
                        <h2 class="card-title m-0">{{ __('All'). ' '.__('Garansi') }}</h2>

                        @role('root')
                        @can('customer.create')
                        <a href="{{ route('garansi.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('New'). ' '.__(' Garansi') }}
                        </a>
                        @endcan
                        @endrole
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTables">
                                <thead>
                                    <tr>
                                        <th rowspan="2" width="5%"> Tanggal Nota </th>
                                        <th rowspan="2"> Nomor Nota </th>
                                        <th rowspan="2"> Nama Barang </th>
                                        <th rowspan="2" width="2%"> Qty </th>
                                        <th colspan="2"> Terproteksi Hingga </th>
                                        <th rowspan="2"> Tambah Proteksi</th>
                                        <th rowspan="2"> Foto Pemasangan</th>
                                        <th rowspan="2"> Status</th>
                                    </tr>
                    
                                    <tr>
                                        <th width="5%">TANGGAL</th>
                                        <th width="35%">HM</th>
                                    </tr>
                    
                                    
                    
                                </thead>
                                <thead hidden>
                                    <tr>
                                        @role('root')
                                        <th scope="col">{{ __('Name') }}</th>
                                        @endrole
                                        <th scope="col">{{ __('No. Nota') }}</th>
                                        <th scope="col">{{ __('Waktu & Tgl. Pemasangan') }}</th>
                                        <th scope="col">{{ __('Masa Berlaku') }}</th>
                                        @canany(['customer.show', 'customer.edit'])
                                        <th scope="col">{{ __('Action') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($garansis))
                                    @foreach ($garansis as $garansi)
                                        <tr>
                                            @role('root')
                                            <td>{{ $garansi->user->name }}</td>
                                            @endrole
                                            <td>
                                                {{ $garansi->no_nota }} <br>
                                                <small> Tgl nota : {{ date('d-m-Y', strtotime($garansi->tanggal_nota)) }} </small>
                                            </td>
                                            <td>
                                                Waktu : {{ date('H:i:s',strtotime($garansi->waktu_pemasangan)) }} <br>
                                                <small> Tgl pemasangan : {{ date('d-m-Y', strtotime($garansi->tanggal_pemasangan)) }} </small>
                                            </td>
                                            <td>
                                                @php
                                                    $websetting = App\Models\WebSetting::first();

                                                    $masa_berlaku = $websetting->masa_berlaku;

                                                    $dateExp = strtotime('+'.$masa_berlaku.' days', strtotime($garansi->tanggal_pemasangan));
                                                    $dateExps = date('d-m-Y', $dateExp);


                                                    $paymentDate = now();
                                                    $paymentDate = date('Y-m-d', strtotime($paymentDate));
                                                    //echo $paymentDate; // echos today!
                                                    $contractDateBegin = date('Y-m-d', strtotime($garansi->tanggal_pemasangan));
                                                    $contractDateEnd = date('Y-m-d', strtotime($dateExps));

                                                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                                                            $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
                                                    }else{
                                                        if($paymentDate <= $contractDateEnd){

                                                            $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
                                                        }else{
                                                            $berlaku_s ='<span class="badge badge-danger"> Berlaku : Expired </span> <br>';
                                                        }

                                                    }
                                                @endphp

                                                {!! $berlaku_s !!}
                                                <small> Sampai : {{ $dateExps }} </small>

                                            </td>

                                            <td>
                                                <a href="{{ route('garansi.show', $garansi->id) }}"
                                                    class="btn btn-primary py-1 px-2">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @role('root')
                                                    <a href="{{ route('garansi.edit', $garansi->id) }}"
                                                        class="btn btn-info py-1 px-2">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('garansi.delete', $garansi->id) }}"
                                                        class="btn btn-danger py-1 px-2 delete-confirm" >
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endrole
                                            </td>

                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        td {
            padding: 5px 10px !important;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00B894',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        getData();
    });

    function getData() {
        //datatables
        table = $('#myTable').DataTable({

            "processing": true,
            "serverSide": true,
            "info": true,
            "order": [],
            "scrollX": true,
            "stateSave": true,
            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, 'Semua']
            ],
            "pageLength": 10,

            lengthChange: true,

            "ajax": {
                "url": "{{ route('garansi.getdata') }}",
                "data": function(d) {
                    d.tglawal = $('input[name="tglawal"]').val();
                    d.tglakhir = $('input[name="tglakhir"]').val();
                }
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'tgl',
                    name: 'bm_tanggal',
                },
                {
                    data: 'bm_kode',
                    name: 'bm_kode',
                },
                {
                    data: 'barang_kode',
                    name: 'barang_kode',
                },
                {
                    data: 'supplier',
                    name: 'supplier_nama',
                },
                {
                    data: 'barang',
                    name: 'barang_nama',
                },
                {
                    data: 'bm_jumlah',
                    name: 'bm_jumlah',
                },
            ],

        });
    }

    function filter() {
        var tglawal = $('input[name="tglawal"]').val();
        var tglakhir = $('input[name="tglakhir"]').val();
        if (tglawal != '' && tglakhir != '') {
            table.ajax.reload(null, false);
        } else {
            validasi("Isi dulu Form Filter Tanggal!", 'warning');
        }

    }

    function reset() {
        $('input[name="tglawal"]').val('');
        $('input[name="tglakhir"]').val('');
        table.ajax.reload(null, false);
    }



    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "Iya."
        });
    }
</script>
@endpush

