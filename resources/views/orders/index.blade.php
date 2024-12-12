@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <h2 class="card-title m-0">
                            Data Pembelian
                        </h2>
                        <div class="d-flex justify-content-end">
                            @role('root')
                            <ul class="nav mb-2 nav-pills justify-content-end">
                                <li class="nav-item ml-2 mr-md-0">
                                    <a class="btn btn-info" data-effect="effect-super-scaled"
                                        data-toggle="modal" href="#modal_import">
                                        <i class="fa fa-upload"></i> Import
                                    </a>
                                </li>
                            </ul>
                            @endrole
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal Nota </th>
                                        <th scope="col">Nomor Nota</th>
                                        <th scope="col">Nama Customer</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Part Number</th>
                                        @canany(['order.show', 'order.print.invioce'])
                                            <th scope="col" class="px-2">{{ __('Actions') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="{{ $order->customer_id ? '' : 'bg-color' }}">
                                            <td class="py-1">
                                                {{ $order->tanggal_nota->format('d/m/Y') }}
                                            </td>
                                            <td class="py-1">{{ $order->nomor_nota }}</td>
                                            <td class="py-1">
                                                {{ $order->nama_customer }}
                                            </td>
                                            <td class="py-1">{{ $order->nama_barang }}</td>
                                            <td class="py-1">{{ $order->qty }}</td>
                                            <td class="py-1">{{ $order->satuan }}</td>
                                            <td class="py-1">{{ $order->part_number }}</td>

                                            @canany(['order.show', 'order.print.invioce'])
                                                <td class="p-1 ">

                                                    @can('order.show')
                                                        <a href="{{ route('order.show', $order->id) }}"
                                                            class="btn btn-primary btn-sm mb-1">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('order.print.invioce')
                                                        <a class="btn btn-danger btn-sm mb-1"
                                                            href="{{ route('order.print.invioce', $order->id) }}"
                                                            target="_blank"><i class="fas fa-print"></i> </a>
                                                    @endcan
                                                </td>
                                            @endcanany
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


<!-- Modal Import -->
<div class="modal fade" data-backdrop="static" id="modal_import">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">

            <div class="card-header">
                <h2 class="card-title m-0">Import</h2>
            </div>
            <form class="modal-dialog-scrollable" enctype='multipart/form-data' action="{{ url('orders/imports') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="mb-1">{{ __('Import') . ' ' . __('Excel') }}</label>
                    <input name="import_data" type="file" />
                </div>
            </div>

            <div class="card-footer">
                <a href="javascript:void(0)" class="btn btn-sm btn-warning" onclick="reset()" data-dismiss="modal"><i class="far fa-window-close"></i> Cancel</a>

                <button type="submit" class="btn btn-sm btn-success float-right"><i class="far fa-save"></i> Submit</button>

            </div>
            </form>
        </div>
    </div>
</div>
@endsection
