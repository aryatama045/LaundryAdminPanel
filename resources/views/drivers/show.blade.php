@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2 class="m-0"> {{ __('Drivers') . ' '.__('Details') }}</h2>

                    <a class="btn btn-light" href="{{ url()->previous() }}"> {{ __('Back') }} </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <tbody>
                                <tr>
                                    <th>{{ __('Name')  }}</th>
                                    <td>{{ $driver->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Driver') . ' '.__('Photo') }}</th>
                                    <td>
                                        <img style="max-width: 100px" src="{{ $driver->user->profile_photo_path }}" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('join_date') }}</th>
                                    <td><strong>{{ $driver->user->created_at->format('d F, Y') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>{{ __('Status') }}</th>
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('driver.status.toggle', $driver->id) }}">
                                                <input {{ $driver->is_approve ? 'checked':'' }} type="checkbox">
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <td>{{ $driver->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Phone_number') }}</th>
                                    <td>
                                        @if ($driver->user->mobile)
                                            {{ $driver->user->mobile }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <th>Passport/Driving Lience</th>
                                    <td>
                                        @if ($driver->user->driving_lience)
                                            {{ $driver->user->driving_lience }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr> --}}
                                <tr>
                                    <th>{{ __('Date_of_Birth') }}</th>
                                    <td>
                                        @if ($driver->user->date_of_birth)
                                            {{ Carbon\Carbon::parse($driver->user->date_of_birth)->format('d F, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm" id="myTable">
                            <thead>
                                <tr>
                                    <th class="px-2">{{ __('Id') }}</th>
                                    <th scope="col" class="px-2">{{ __('Order') . ' '.__('Date') }}</th>
                                    <th scope="col" class="px-2">{{ __('Pickup') . ' '.__('Date') }}</th>
                                    <th scope="col" class="px-2">{{ __('Delivery') . ' '.__('Status') }}</th>
                                    <th scope="col" class="px-2">{{ __('Order') . ' '.__('Status') }}</th>
                                    <th scope="col" class="px-2 text-center">{{ __('Amount') }}</th>
                                    <th scope="col" class="px-2 text-center">{{ __('Assign') }}</th>
                                    <th scope="col" class="px-2 text-center">{{ __('Accepted') }}</th>
                                    <th scope="col" class="px-2 text-center">{{ __('Action')  }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($driver->orders as $order)
                                    <tr>
                                        <td class="px-2">
                                            {{ $order->prefix.$order->order_code }}
                                        </td>
                                        <td class="px-2">
                                            {{ $order->created_at->format('M d, Y') }}<br>
                                            <small>{{ $order->created_at->format('h:i a') }}</small>
                                        </td>
                                        <td class="px-2">
                                            <span style="font-size: 14px">
                                                {{ Carbon\Carbon::parse($order->pick_date)->format('M d, Y') }}<br>
                                            </span>
                                            <small>
                                                {{ $order->getTime(substr($order->pick_hour, 0, 2)) }}
                                            </small>
                                        </td>
                                        <td class="px-2">
                                            <span style="font-size: 14px">
                                                {{ Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}<br>
                                            </span>
                                            <small>
                                                {{ $order->getTime(substr($order->delivery_hour, 0, 2)) }}
                                            </small>
                                        </td>
                                        <td class="px-2">{{ $order->order_status }}</td>
                                        <td class="px-2 text-center">{{ $order->amount - $order->discount }}</td>
                                        <td class="px-2 text-center text-capitalize">{{ $order->pivot->status }}</td>
                                        <td class="px-2 text-center">
                                            @if ($order->pivot->is_accept)
                                                <span class="text-success">{{ __('Accepted') }}</span>
                                            @else
                                                <span class="text-danger">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-2 text-center">
                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($driver->orderHistories as $order)
                                    <tr>
                                        <td class="px-2">
                                            {{ $order->prefix.$order->order_code }}
                                        </td>
                                        <td class="px-2">
                                            {{ $order->created_at->format('M d, Y') }}<br>
                                            <small>{{ $order->created_at->format('h:i a') }}</small>
                                        </td>
                                        <td class="px-2">
                                            <span style="font-size: 14px">
                                                {{ Carbon\Carbon::parse($order->pick_date)->format('M d, Y') }}<br>
                                            </span>
                                            <small>
                                                {{ $order->getTime(substr($order->pick_hour, 0, 2)) }}
                                            </small>
                                        </td>
                                        <td class="px-2">
                                            <span style="font-size: 14px">
                                                {{ Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}<br>
                                            </span>
                                            <small>
                                                {{ $order->getTime(substr($order->delivery_hour, 0, 2)) }}
                                            </small>
                                        </td>
                                        <td class="px-2">{{ $order->order_status }}</td>
                                        <td class="px-2 text-center">{{ $order->amount - $order->discount }}</td>
                                        <td class="px-2 text-center text-capitalize">{{ $order->pivot->status }}</td>
                                        <td class="px-2 text-center">
                                            <span class="text-success">{{ __('Accepted') }}</span>
                                        </td>
                                        <td class="px-2 text-center">
                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
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
