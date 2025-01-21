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
                                            <td class="py-1"> </td>
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


@endsection
