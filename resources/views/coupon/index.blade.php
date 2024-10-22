@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">{{ __('Coupons') }}</h2>
                        </div>

                        @can('coupon.create')
                        <div class="col-6 position-relative" >
                            <div class="position-absolute" style="right: 1em" >
                                <a href="{{ route('coupon.create') }}" class="btn btn-primary">{{ __('Create'). ' '.__('Coupon') }}</a>
                            </div>
                        </div>
                        @endcan
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm {{ session()->get('local') }}" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Code') }}</th>
                                    <th scope="col">{{ __('Discount_Type') }} </th>
                                    <th scope="col">{{ __('Discount') }}</th>
                                    <th scope="col">{{ __('Min_Amount') }}</th>
                                    <th scope="col">{{ __('Started_at') }}</th>
                                    <th scope="col">{{ __('Expired_at') }}</th>
                                    @can('coupon.edit')
                                    <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code}}</td>
                                    <td>{{ __($coupon->discount_type) }}</td>
                                    <td>{!! $coupon->discount_type == 'amount' ? currencyPosition($coupon->discount) : $coupon->discount.'%' !!}</td>
                                    <td>{{ currencyPosition($coupon->min_amount) }}</td>
                                    <td>{{ Carbon\Carbon::parse($coupon->started_at)->format('M d, Y h:i a') }}</td>
                                    <td>{{ Carbon\Carbon::parse($coupon->expired_at)->format('M d, Y h:i a') }}</td>

                                    @can('coupon.edit')
                                    <td>
                                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endcan
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
