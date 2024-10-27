@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">{{ __('Customer').' '.__('Details') }}</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ url()->previous() }}"> {{ __('Back') }} </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Details') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>{{ __('Company') }}</th>
                                    <td>{{ $customer->user->company ? $customer->user->company : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $customer->user->first_name ? $customer->user->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Profile_Photo') }}</th>
                                <td>
                                    <img width="100" src="{{ $customer->user->profilePhotoPath }}" alt="{{ $customer->user->name }}">
                                </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <td>
                                        {{ $customer->user->email }}
                                        @if ($customer->user->email_verified_at)
                                            <span class="bg-success btn py-0 px-1">{{ $customer->user->email_verified_at->format('M d, Y') }}</span>
                                            @else
                                            <span class="bg-warning btn py-0 px-1">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Mobile') }}</th>
                                    <td>
                                        {{ $customer->user->mobile }}
                                        @if ($customer->user->mobile_verified_at)
                                            <span class="bg-success btn py-0 px-1">{{ __('verified') }}</span>
                                            @else
                                            <span class="bg-warning btn py-0 px-1">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __('Date_of_Birth') }}</th>
                                    <td>{{ Carbon\Carbon::parse($customer->user->dob)->format('M d, Y') }}</td>
                                </tr>

                                @if (!$customer->addresses->isEmpty())
                                <tr>
                                    <th>{{ __('Address') }}</th>
                                    <td>
                                        @foreach ($customer->addresses as $key => $address)
                                        <div>
                                            {!! $key == 0 ? ' <hr class="my-2">' : '' !!}

                                            <span>{{ $address->address_line . ',' . $address->address_line2 }}</span>

                                            <a href="#address_show_{{ $address->id }}" data-toggle="modal" class="btn btn-info p-1 px-2 ml-2">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <hr class="my-2">
                                            <!-- Modal -->
                                            <div class="modal fade" id="address_show_{{ $address->id }}">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $address->address_line }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="col">{{ __('Title') }}</th>
                                                                    <th scope="col">{{ __('Details') }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('Post_Code') }}</td>
                                                                    <td>{{ $address->post_code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('Address_line') }} 1</td>
                                                                    <td>{{ $address->address_line }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('Address_line') }} 2</td>
                                                                    <td>{{ $address->address_line2 }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('Delivery').' '.__('Note') }}</td>
                                                                    <td>{{ $address->delivery_note }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif

                                @if (!$customer->orders->isEmpty())
                                <tr>
                                    <th>{{ __('Orders') }}</th>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                                            {{ __('Show_all_Orders') }}
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">{{ __('All') .' '.__('Orders') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach ($customer->orders as $key => $order)
                                                    <div class="position-relative">
                                                        {!! $key == 0 ? ' <hr class="my-2">' : '' !!}
                                                        @if (session()->get('local') == 'ar')
                                                        <span> {{ $order->products->count() }} :{{ __('Products') }}</span>,
                                                        <span>{{ Carbon\Carbon::parse($order->delivery_at)->format('M d, Y') }} :{{ __('Delivery_Date') }}</span>,

                                                        @else
                                                        <span>{{ __('Delivery_Date') }}: {{ Carbon\Carbon::parse($order->delivery_at)->format('M d, Y') }}</span>,
                                                        <span>{{ __('Products') }}: {{ $order->products->count() }}</span>
                                                        @endif
                                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-info p-1 px-2 ml-2 position-absolute" style="right:0; bottom:5px">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <hr class="my-2">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-dismiss="modal">{{ __('Close') }}</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
