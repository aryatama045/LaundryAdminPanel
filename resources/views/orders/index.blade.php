@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <h2 class="card-title m-0">
                            {{ __(config('enums.order_status.' . request('status'))) }}
                            {{ __('Data Pembelian') }}
                        </h2>
                        <div class="d-flex justify-content-end">
                            <form class="" action="{{ route('order.index') }}" method="GET">

                                <select class="form-control mx-2 float-left" name="status" style="width: 200px">
                                    <option value="">
                                        {{ in_array(config('enums.order_status.' . \request('status')), config('enums.order_status')) ? __(config('enums.order_status.' . request('status'))) : __('All') }}
                                    </option>

                                    @foreach (config('enums.order_status') as $key => $order_status)
                                        <option value="{{ $key }}"
                                            {{ $key == \request('status') ? 'selected' : '' }}>{{ __($order_status) }}
                                        </option>
                                    @endforeach
                                </select>

                                <button class="btn btn-primary mx-md-0 mx-2"> <i
                                        class="fa fa-search"></i> </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Order') . ' ' . __('Id') }} </th>
                                        <th scope="col">{{ __('Order') . ' ' . __('By') }}</th>
                                        <th scope="col">{{ __('Order') . ' ' . __('At') }}</th>
                                        <th scope="col">{{ __('Pickup') . ' ' . __('Date') }}</th>
                                        <th scope="col">{{ __('Delivery') . ' ' . __('Date') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Order') . ' ' . __('Status') }}</th>
                                        @canany(['order.show', 'order.print.invioce'])
                                            <th scope="col" class="px-2">{{ __('Actions') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="{{ $order->is_show ? '' : 'bg-color' }}">
                                            <td class="py-1">{{ $order->prefix . $order->order_code }}</td>
                                            <td class="py-1">
                                                {{ $order->customer->user ? $order->customer->user->name : 'N/A' }}
                                            </td>
                                            <td class="py-1">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>

                                            <td class="py-1">
                                                {{ \Carbon\Carbon::parse($order->pick_date)->format('M d, Y') }}
                                            </td>
                                            <td class="py-1">
                                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}
                                            </td>
                                            <td class="py-1">{{ currencyPosition($order->total_amount) }}</td>
                                            <td class="py-1">{{ __($order->order_status) }}</td>
                                            @canany(['order.show', 'order.print.invioce'])
                                                <td class="p-1 ">
                                                    <a href="#address{{ $order->id }}" data-toggle="modal"
                                                        class="btn btn-primary btn-sm mb-1">
                                                        <i class="fa fa-address-card"></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="address{{ $order->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        {{ __('Order') . ' ' . __('Address') }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                        <p>{{ __('Order') . ' ' . __('Id') }}:
                                                                            <strong>{{ $order->prefix . $order->order_code }}</strong>
                                                                        </p>
                                                                        <p>
                                                                            {{ __('Order') . ' ' . __('From') }}:
                                                                            <strong>{{ $order->address->address_name }}</strong>
                                                                        </p>
                                                                        <p>
                                                                            {{ __('Post_Code') }}:
                                                                            <strong>{{ $order->address->post_code }}</strong>
                                                                        </p>
                                                                        <p>
                                                                            {{ __('Address_line') }} 1:
                                                                            <strong>{{ $order->address->address_line }}</strong>
                                                                        </p>

                                                                        <p>
                                                                            {{ __('Address_line') }} 2:
                                                                            <strong>{{ $order->address->address_line2 }}</strong>
                                                                        </p>
                                                                        <p>
                                                                            {{ __('Delivery') . ' ' . __('Note') }}:
                                                                            <strong>{{ $order->address->delivery_note }}</strong>
                                                                        </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-dark btn-sm"
                                                                        data-dismiss="modal">{{ __('Close') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
@endsection
