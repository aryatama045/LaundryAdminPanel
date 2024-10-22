@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title m-0">
                        {{ __('Order') . ' ' . __('Details') . ' ' . __('of') }} {{ $order->customer->user->name }}
                    </h3>

                    <div class="">
                        <a class="btn btn-light" href="{{ route('order.index') }}"> {{ __('Back') }} </a>
                        @can('order.print.invioce')
                            <a class="btn btn-danger" href="{{ route('order.print.invioce', $order->id) }}" target="_blank">
                                <i class="fas fa-print"></i> {{ __('Print') }}
                            </a>
                        @endcan

                        @can('order.status.change')
                            <div class="drop-down">
                                <a class="btn btn-primary @role('visitor') visitorMessage @endrole" style="min-width:150px" href="#status @role('visitor') visitor @endrole" data-toggle="collapse"
                                    aria-expanded="false" role="button" aria-controls="navbar-examples">
                                    <span class="nav-link-text">{{ __($order->order_status) }}</span>
                                    <i class="fa fa-chevron-down"></i>
                                </a>

                                <div class="collapse drop-down-items mt-1" id="status">
                                    <ul class="nav nav-sm flex-column">
                                        @foreach (config('enums.order_status') as $key => $order_status)
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('order.status.change', ['order' => $order->id, 'status' => $key]) }}">
                                                    {{ __($order_status) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endcan

                        @if ($order->drivers->isEmpty() && $order->order_status != 'Delivered' && count($order->driverHistories) < 2)
                            <button class="btn btn-primary" data-toggle="modal"
                                data-target="#assinDriver">{{ __('Assign_driver') }}</button>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card d-flex flex-column h-100">
                    <div class="card-header py-2">
                        <h2 class="m-0">{{ __('Order') . ' ' . __('Details') }}</h2>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive-md">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}">
                                <tr>
                                    <th class="py-2">{{ __('Order') . ' ' . __('Status') }}</th>
                                    <td class="py-2">{{ __($order->order_status) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Assign_driver') }}</th>
                                    <td>
                                        @if ($order->drivers->isNotEmpty())
                                            <li>
                                                <strong> {{ $order->drivers[0]->user->name }} </strong>
                                            </li>
                                        @endif
                                        @foreach ($order->driverHistories as $orderHistory)
                                            <li>
                                                <strong> {{ $orderHistory->driver->user->name }}</strong>
                                                <span
                                                    class="badge badge-pill badge-primary text-capitalize">{{ $orderHistory->status }}</span>
                                            </li>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Payment') . ' ' . __('Status') }}</th>
                                    <td class="py-2">
                                        @if ($order->payment_status != 'Paid')
                                            <div class="d-flex justify-content-between align-items-center">
                                                {{ __($order->payment_status) }}
                                                <a href="{{ route('orderIncomplete.paid', $order->id) }}"
                                                    class="btn btn-primary py-2 px-4 paid-confirm">{{ __('Paid') }}</a>
                                            </div>
                                        @else
                                            {{ __($order->payment_status) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Total') . ' ' . __('Amount') }}</th>
                                    <td class="py-2">{{ currencyPosition($order->total_amount) }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Discount') }}</th>
                                    <td class="py-2">{{ currencyPosition($order->discount) }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Delivery_charge') }}</th>
                                    <td class="py-2">{{ currencyPosition($order->delivery_charge) }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Total') . ' ' . __('Quantity') }}</th>
                                    <td class="py-2">{{ $quantity . ' ' . __('Pieces') }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Items') }}</th>
                                    <td class="py-2">{{ $order->products->count() }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Picked') . ' ' . __('Date') }}</th>
                                    <td class="py-2">
                                        {{ Carbon\Carbon::parse($order->pick_date)->format('F d, Y') }}
                                        <span class="badge badge-pill bg-light text-dark" style="font-size: 14px">
                                            {{ $order->getTime(substr($order->pick_hour, 0, 2)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Delivery') . ' ' . __('Date') }}</th>
                                    <td class="py-2">
                                        {{ Carbon\Carbon::parse($order->delivery_date)->format('F d, Y') }}
                                        <span class="badge badge-pill bg-light text-dark" style="font-size: 14px">
                                            {{ $order->getTime(substr($order->delivery_hour, 0, 2)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2">
                <div class="card d-flex flex-column h-100">
                    <div class="card-header py-2">
                        <h2 class="m-0">{{ __('Customer') . ' ' . __('Details') }}</h2>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive-md">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}">
                                <tr>
                                    <th class="py-2">{{ __('Name') }}</th>
                                    <td class="py-2" class="py-2">{{ $order->customer->user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Customer') . ' ' . __('Photo') }}</th>
                                    <td class="py-2">
                                        <img style="max-width: 80px" src="{{ $order->customer->profilePhotoPath }}"
                                            alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Email') }}</th>
                                    <td class="py-2">{{ $order->customer->user->email }}
                                        @if ($order->customer->user->email_verified_at)
                                            <span class="badge bg-success text-dark">{{ __('verified') }}</span>
                                        @else
                                            <span class="badge bg-danger text-white">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="py-2">{{ __('Phone_number') }}</th>
                                    <td class="py-2">
                                        @if ($order->customer->user->mobile)
                                            {{ $order->customer->user->mobile }}
                                            @if ($order->customer->user->mobile_verified_at)
                                                <span class="badge bg-success text-dark">{{ __('verified') }}</span>
                                            @else
                                                <span class="badge bg-danger text-white">{{ __('Unverified') }}</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 my-2">
                <div class="card">
                    <div class="card-header py-2">
                        <h2 class="m-0"> {{ __('Others Details') }}</h2>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive-md">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th class="py-2 {{ session()->get('local') == 'ar' ? 'text-right' : '' }}">
                                        {{ __('Address') }}</th>
                                    <td class="py-2">
                                        <table class="table table-bordered {{ session()->get('local') }}">
                                            <tr>
                                                <th>{{ __('Area') }}</th>
                                                <th>{{ __('Address') . ' ' . __('Name') }}</th>
                                                <th>{{ __('Flat_No') }}.</th>
                                                <th>{{ __('House_No') }}</th>
                                                <th>{{ __('Block') }}</th>
                                                <th>{{ __('Road_No') }}.</th>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ $order->address->area }}</strong></td>
                                                <td><strong>{{ $order->address->address_name }}</strong></td>
                                                <td><strong>{{ $order->address->flat_no }}</strong></td>
                                                <td><strong>{{ $order->address->house_no }}</strong></td>
                                                <td><strong>{{ $order->address->block }}</strong></td>
                                                <td><strong>{{ $order->address->road_no }}</strong></td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="py-2 {{ session()->get('local') == 'ar' ? 'text-right' : '' }}">
                                        {{ __('Products') }}</th>
                                    <td class="py-2">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#staticBackdrop">
                                            {{ __('Show') . ' ' . __('All') . ' ' . __('Order') . ' ' . __('Products') }}
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                            {{ __('All') . ' ' . __('Order') . ' ' . __('Products') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @foreach ($order->products as $product)
                                                            <div class="bg-white my-2 py-2 overflow-hidden">
                                                                <img width="120" class="float-left mr-4"
                                                                    src="{{ $product->thumbnailPath }}" alt="">
                                                                <div class="overflow-hidden">
                                                                    <h4>{{ session()->get('local' == 'ar' ? $product->name_bn : $product->name) }}
                                                                    </h4>
                                                                    <p class="m-0">{{ __('Price') }}:
                                                                        {{ $product->discount_price ?? $product->price }}
                                                                    </p>
                                                                    <p>{{ __('Quantity') }}:
                                                                        {{ $product->pivot->quantity }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-dark"
                                                            data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="py-2 {{ session()->get('local') == 'ar' ? 'text-right' : '' }}">
                                        {{ __('Labels') }}</th>
                                    <td class="py-2">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#labals">
                                            {{ __('Order') . ' ' . __('Products') }}
                                        </button>

                                        @can('order.print.labels')
                                            <a href="{{ route('order.print.labels', ['order' => $order->id, 'quantity' => $quantity]) }}"
                                                target="_blank" class="btn btn-danger">
                                                {{ __('Print') }} <i class="fas fa-print"></i>
                                            </a>
                                        @endcan

                                        <!-- Modal -->
                                        <div class="modal fade" id="labals">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content" style="background: #f6f6f6;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                            {{ __('All') . ' ' . __('Order') . ' ' . __('Labels') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @php
                                                                $r = 1;
                                                            @endphp
                                                            @foreach ($order->products as $key => $product)
                                                                @for ($i = 0; $i < $product->pivot->quantity; $i++)
                                                                    <div class="col-4">
                                                                        <div
                                                                            class="card text-dark bg-white shadow bg-body rounded my-2 p-2">
                                                                            <h4 class="m-0">{{ __('Name') }}:
                                                                                {{ $order->customer->user->name }}</h4>
                                                                            <h4 class="m-0">{{ __('Order Id') }}:
                                                                                #{{ $order->prefix . $order->order_code }}
                                                                            </h4>
                                                                            <h4 class="m-0">{{ __('Date') }}:
                                                                                {{ Carbon\Carbon::parse($order->delivery_at)->format('M d, Y') }}
                                                                            </h4>
                                                                            <h4 class="m-0">{{ __('Title') }}:
                                                                                {{ $product->name }}
                                                                            </h4>
                                                                            <h4 class="m-0">{{ __('Item') }}:
                                                                                {{ $r . '/' . $quantity }}</h4>
                                                                        </div>
                                                                    </div>
                                                                @endfor
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-dark"
                                                            data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="py-2 {{ session()->get('local') == 'ar' ? 'text-right' : '' }}">
                                        {{ __('Additional_Instruction') }}:</th>
                                    <td class="py-2">{{ $order->instruction ?? 'N\A' }}</td>
                                </tr>

                                <tr>
                                    <th class="py-2 {{ session()->get('local') == 'ar' ? 'text-right' : '' }}">
                                        {{ __('Additional_Service') }}</th>
                                    <td class="py-2">
                                        <button type="button" data-target="#additional" data-toggle="modal"
                                            class="btn btn-primary">
                                            {{ __('Additional_Services') }} <span
                                                class="badge badge-dark m-0">{{ $order->additionals->count() }}</span>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="additional">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" style="background: #f6f6f6;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                            {{ __('All') . ' ' . __('Order') . ' ' . __('Labels') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table
                                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Description') }}</th>
                                                                <th>{{ __('Price') }}</th>
                                                            </tr>
                                                            @foreach ($order->additionals as $additional)
                                                                <tr>
                                                                    <td>{{ $additional->title }}</td>
                                                                    <td>{{ $additional->description }}</td>
                                                                    <td>{{ $additional->price }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-dark"
                                                            data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="py-2 {{ session()->get('local') == 'ar' ? 'text-right' : '' }}">
                                        {{ __('Rating') }}</th>
                                    <td class="py-2">
                                        @php
                                            $rate = $order->rating ? $order->rating->rating : 0;
                                        @endphp
                                        <i class="fas fa-star {{ $rate >= 1 ? 'rate' : 'unrate' }}"></i>
                                        <i class="fas fa-star {{ $rate >= 2 ? 'rate' : 'unrate' }}"></i>
                                        <i class="fas fa-star {{ $rate >= 3 ? 'rate' : 'unrate' }}"></i>
                                        <i class="fas fa-star {{ $rate >= 4 ? 'rate' : 'unrate' }}"></i>
                                        <i class="fas fa-star {{ $rate == 5 ? 'rate' : 'unrate' }}"></i>

                                        <br>
                                        {{ $order->rating ? $order->rating->content : null }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="assinDriver">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Select Driver') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered {{ session()->get('local') }}">
                                <tr>
                                    <td>{{ __('Name') }}</td>
                                    <td>{{ __('Email') }}</td>
                                    <td>{{ __('Contact') }}</td>
                                    <td>{{ __('Action') }}</td>
                                </tr>
                                @foreach ($drivers as $driver)
                                    @php
                                        $pickup = 0;
                                        $delivery = 0;
                                        foreach ($driver->orders as $driverOrder) {
                                            if ($driverOrder->pick_date == $order->pick_date && $driverOrder->getTime($driverOrder->pick_hour) == $order->getTime($order->pick_hour)) {
                                                $pickup += 1;
                                            }
                                            if ($driverOrder->delivery_date == $order->delivery_date && $driverOrder->getTime($driverOrder->delivery_hour) == $order->getTime($order->delivery_hour)) {
                                                $delivery += 1;
                                            }
                                        }
                                    @endphp
                                    @if ($pickup < 4 || $delivery < 4)
                                        <tr>
                                            <td class="py-2">{{ $driver->user->name }}</td>
                                            <td class="py-2">{{ $driver->user->email }}</td>
                                            <td class="py-2">{{ $driver->user->mobile }}</td>
                                            <td class="py-2">
                                                <a href="{{ route('driver.assign', [$order->id, $driver->id]) }}"
                                                    class="btn btn-primary">{{ __('Assign') }}</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <style>
            .rate {
                color: rgb(255, 166, 0)
            }

            .unrate {
                color: rgb(136, 136, 136)
            }
        </style>
    </div>
@endsection

@push('scripts')
    <script>
        $('.paid-confirm').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00B894',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Paid it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>
@endpush
