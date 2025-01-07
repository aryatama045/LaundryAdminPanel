@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">Code</h2>
                        </div>


                        <div class="col-md-8">
                            <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item ml-2 mr-md-0">
                                    <a class="btn btn-info" data-effect="effect-super-scaled"
                                        data-toggle="modal" href="#modal_import">
                                        <i class="fa fa-upload"></i> Import
                                    </a>
                                </li>
                                <li class="nav-item ml-2 mr-md-0">
                                    <a href="{{ route('coupon.create') }}" class="btn btn-primary">Create</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm " id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code}}</td>
                                    <td>
                                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
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
