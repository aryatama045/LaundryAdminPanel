@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">{{ __('Code') }}</h2>
                        </div>

                        @can('coupon.create')
                        <div class="col-6 position-relative" >
                            <div class="position-absolute" style="right: 1em" >
                                <a href="{{ route('coupon.create') }}" class="btn btn-primary">{{ __('Create'). ' }}</a>
                            </div>
                        </div>
                        @endcan
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm " id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    @can('coupon.edit')
                                    <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code}}</td>
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
