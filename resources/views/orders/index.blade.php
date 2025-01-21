@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <h2 class="card-title m-0">
                            Data Retur
                        </h2>

                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Tanggal Nota </th>
                                        <th scope="col">Nomor Nota</th>
                                        <th scope="col">Nama Customer</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">No. Retur</th>
                                        <th scope="col">Alasan Retur</th>
                                        <th scope="col">Approval Retur</th>
                                        @role('root')
                                            <th hidden scope="col" class="px-2">{{ __('Actions') }}</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="">
                                            <td class="py-1">
                                                {{ \Carbon\Carbon::parse($order->tanggal_nota)->format('d/m/Y') }}
                                            </td>
                                            <td class="py-1">
                                                {{ \Carbon\Carbon::parse($order->tanggal_nota)->format('d/m/Y') }}
                                            </td>
                                            <td class="py-1">{{ $order->nomor_nota }}</td>
                                            <td class="py-1">
                                                {{ $order->nama_customer }}
                                            </td>
                                            <td class="py-1">{{ $order->nama_barang }}</td>
                                            <td class="py-1">{{ $order->qty }}</td>
                                            <td class="py-1">{{ $order->satuan }}</td>
                                            <td class="py-1">
                                                <?php
                                                    if($order->nomor_retur != NULL){
                                                        $nomor_retur = $order->nomor_retur;
                                                    }else{
                                                        $nomor_retur = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$order->id.'" data-original-title="Retur Add" class="edit btn btn-primary btn-sm editProduct">Retur Add</a>';
                                                    }
                                                ?>
                                                {!! $nomor_retur !!}
                                            </td>
                                            <td class="py-1"> </td>
                                            <td class="py-1"> {{ $order->order_status }} </td>
                                            @role('root')
                                                <td hidden class="p-1 ">

                                                    <a href="{{ route('order.show', $order->id) }}"
                                                        class="btn btn-primary btn-sm mb-1">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a class="btn btn-danger btn-sm mb-1"
                                                        href="{{ route('order.print.invioce', $order->id) }}"
                                                        target="_blank"><i class="fas fa-print"></i> </a>

                                                </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<div class="modal fade" id="ajaxModel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="modelHeading"></h4>

            </div>

            <div class="modal-body">

                <form id="productForm" name="productForm" class="form-horizontal">

                    <input type="hidden" name="order_id" id="order_id">

                    <div class="form-group">
                        <label for="nomor_nota" class="col-sm-2 control-label">Nomor Nota</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nomor_nota" name="nomor_nota" placeholder="Enter Input" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_nota" class="col-sm-2 control-label">Tanggal Nota</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="tanggal_nota" name="tanggal_nota" placeholder="Enter Input" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang" class="col-sm-2 control-label">Nama Barang</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Enter Input" value="" maxlength="50" required="">
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
<script type="text/javascript">

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '.editProduct', function () {
        var order_id = $(this).data('id');
        $.get("{{ route('orders.index') }}" +'/' + order_id +'/data_retur', function (data) {

            $('#modelHeading').html("Retur");

            $('#saveBtn').val("edit-user");

            $('#ajaxModel').modal('show');

            $('#order_id').val(data.id);

            $('#name').val(data.name);

            $('#detail').val(data.detail);

        });
    });

});

</script>
@endpush
