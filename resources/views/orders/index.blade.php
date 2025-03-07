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
                                        <!-- <th scope="col">Qty Retur</th> -->
                                        <th scope="col">Satuan</th>
                                        <th scope="col">No. Retur</th>
                                        <th scope="col">Alasan Retur</th>
                                        <th scope="col">Tanggal Retur</th>
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
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}
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
                                            <!-- <td class="py-1">{{ $order->qty_retur }}</td> -->
                                            <td class="py-1">{{ $order->satuan }}</td>
                                            <td class="py-1">
                                                <?php if($order->nomor_retur != NULL){
                                                    echo $nomor_retur = $order->nomor_retur; ?>

                                                    @role('admin|visitor')
                                                        <br><a href="javascript:void(0)"
                                                        id="show-user" data-url="{{ route('order.dataRetur', $order->id) }}"
                                                        class='edit btn btn-primary btn-sm'>Retur Add</a>
                                                    @endrole

                                                <?php }else{ ?>

                                                    @role('admin|visitor')
                                                        <a href="javascript:void(0)"
                                                        id="show-user" data-url="{{ route('order.dataRetur', $order->id) }}"
                                                        class='edit btn btn-primary btn-sm'>Retur Add</a>
                                                    @endrole

                                                    @role('customer')
                                                        -
                                                    @endrole

                                                <?php } ?>
                                            </td>
                                            <td class="py-1"> {{ $order->alasan_retur }} </td>
                                            <td class="py-1"> {{ \Carbon\Carbon::parse($order->tanggal_retur)->format('d/m/Y') }} </td>
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




<div class="modal fade" id="userShowModal" aria-hidden="true">

    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>

            <div class="modal-body">

                <form  action="{{ route('order.retur_action') }}"   method="POST" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">

                    <div class="form-group">
                        <label for="nomor_nota" class="col-sm-6 control-label">Nomor Nota</label>
                        <div class="col-sm-12">
                            <input disabled type="text" class="form-control" id="nomor_nota" name="nomor_nota" placeholder="Enter Input" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_nota" class="col-sm-6 control-label">Tanggal Nota</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="tanggal_nota" name="tanggal_nota" placeholder="Enter Input" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_customer" class="col-sm-6 control-label">Nama Customer</label>
                        <div class="col-sm-12">
                            <input type="text" disabled class="form-control" id="nama_customer" name="nama_customer" placeholder="Enter Input" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang" class="col-sm-6 control-label">Nama Barang</label>
                        <div class="col-sm-12">
                            <input disabled type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Enter Input" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_retur" class="col-sm-6 control-label">Nomor Retur</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="nomor_retur" placeholder="Enter Nomor retur"required="" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Alasan Retur</label>
                        <div class="col-sm-12">
                            <textarea id="alasan_retur" name="alasan_retur" required="" placeholder="Enter Alasan" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="qty" class="col-sm-6 control-label">Qty Barang</label>
                        <div class="col-sm-12">
                            <p id="elem_qty"></p>
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

    <script type="text/javascript">
        $(document).ready(function () {

            /* When click show user */
            $('body').on('click', '#show-user', function () {
                var userURL = $(this).data('url');
                $.get(userURL, function (data) {
                    $('#userShowModal').modal('show');
                    elem_qty ="";
                    elem_qty += '<input type="number" class="form-control" id="qty" name="qty" min="1" max="' + data.qty + '"' +
                        'value="' + data.qty + '" onkeyup=imposeMinMax(this)>';
                    document.getElementById("elem_qty").innerHTML = elem_qty;

                    $('#order_id').val(data.id);
                    $('#nomor_nota').val(data.nomor_nota);
                    $('#tanggal_nota').val(data.tanggal_nota);
                    $('#nama_customer').val(data.nama_customer);
                    $('#nama_barang').val(data.nama_barang);
                    // $('#qty').val(data.qty);
                })
            });

        });
    </script>

@endpush
