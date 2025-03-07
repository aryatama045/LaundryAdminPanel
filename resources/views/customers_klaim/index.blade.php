@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center py-2 justify-content-between">
                        @role('root')
                            <h2 class="card-title m-0">{{ __('All'). ' '.__('Klaim') }}</h2>
                        @endrole

                        @role('customer')
                            <h2 class="card-title m-0">Data Klaim</h2>
                        @endrole

                        @role('admin')
                            <h2 class="card-title m-0">Data Klaim</h2>
                        @endrole

                        @role('customer')
                        <!-- <a href="{{ route('klaim.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('New'). ' '.__(' Klaims') }}
                        </a> -->
                        @endrole
                    </div>

                    <div class="col-md-6 mt-3 mb-2">
                        <div class="form-inline ">
                            <div class="form-group mb-2">
                                <label for="tglawal" class="sr-only">Tanggal Awal</label>
                                <input type="date" name="tglawal" class="form-control datepicker-date" placeholder="Tanggal Awal">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="tglakhir" class="sr-only">Tanggal Akhir</label>
                                <input type="date" name="tglakhir" class="form-control datepicker-date" placeholder="Tanggal Akhir">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" onclick="filter()"><i class="fe fe-filter"></i> Filter</button>
                            <button class="btn btn-secondary-light" onclick="reset()"><i class="fe fe-refresh-ccw"></i> Reset</button>
                        </div>
                    </div>

                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable table-striped " id="tables-1">
                                <thead>
                                    <tr>
                                        <th rowspan="2" width="3%"> No. </th>
                                        <th rowspan="2" width="10%"> Tanggal </th>
                                        <th rowspan="2" width="10%"> Tanggal Nota </th>
                                        <th rowspan="2"> Nomor Nota </th>
                                        <th rowspan="2"> Nama Customer </th>
                                        <th rowspan="2"> Nama Barang </th>
                                        <th rowspan="2" width="2%"> Qty </th>
                                        <th rowspan="2"> Terproteksi</th>
                                        <th colspan="2"> Tanggal & Waktu Rusak</th>
                                        <th rowspan="2"> Klaim Proteksi</th>
                                        <th rowspan="2" class="text-center"> Foto Barang Rusak</th>
                                        <th rowspan="2"> Status</th>
                                        <th rowspan="2"> Garansi Disetujui</th>
                                    </tr>

                                    <tr>
                                        <th width="10%">TANGGAL</th>
                                        <th width="10%">WAKTU</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>

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

    <!-- MODAL GAMBAR -->
    <div class="modal fade" id="Gmodaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo bg-transparent border-0 shadow-none">
                <div class="modal-body text-center p-4 pb-5">
                    <button type="reset" aria-label="Close" class="btn-close position-absolute" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                    <img src="{{url('/assets/default/barang/image.png')}}" width="100%" alt="profile-user" id="outputImgG" class="">
                </div>
            </div>
        </div>
    </div>

    
<div class="modal fade" id="userShowModal" aria-hidden="true">

    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>

            <div class="modal-body">

                <form  action="{{ route('klaim.klaim_action') }}"   method="POST" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="garansi_id"  id="garansi_id">

                    <div class="form-group">
                        <label for="qty" class="col-sm-6 control-label">Tambah Hari Garansi</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="tambah_hari" value="1" required="" >
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


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

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        });

        $(document).ready(function() {
            getData();
        });

        function getData() {
            //datatables
            table = $('#tables-1').DataTable({

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
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('klaim.index') }}",
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
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'tanggal_nota',
                        name: 'tanggal_nota',
                    },
                    {
                        data: 'nomor_nota',
                        name: 'nomor_nota',
                    },
                    {
                        data: 'nama_customer',
                        name: 'nama_customer',
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang',
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                    },
                    {
                        data: 'terproteksi',
                        name: 'terproteksi',
                    },
                    {
                        data: 'tanggal_rusak',
                        name: 'tanggal_rusak',
                    },
                    {
                        data: 'waktu_rusak',
                        name: 'waktu_rusak',
                    },
                    {
                        data: 'klaim_proteksi',
                        name: 'klaim_proteksi',
                    },
                    {
                        data: 'img',
                        name: 'barang_gambar',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
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
            // swal({
            //     title: judul,
            //     type: status,
            //     confirmButtonText: "Iya."
            // });

            Swal.fire({
                title: judul,
                type: status,
                icon: 'warning',
                showCancelButton: true,
                // confirmButtonColor: '#00B894',
                cancelButtonColor: '#d33',
                // confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }

        function gambar(data) {
            if(data.barang_gambar != 'image.png'){
                $("#outputImgG").attr("src", "{{Storage::url('/')}}" + data.barang_gambar);
            }else{
                $("#outputImgG").attr("src", "{{url('/images/dummy/dummy-placeholder.png')}}");
            }
        }
    </script>

    
    <script type="text/javascript">
        $(document).ready(function () {

            /* When click show user */
            $('body').on('click', '#show-user', function () {
                var userURL = $(this).data('url');
                $.get(userURL, function (data) {
                    $('#userShowModal').modal('show');
                    $('#garansi_id').val(data.id);
                })
            });

        });
    </script>
@endpush


