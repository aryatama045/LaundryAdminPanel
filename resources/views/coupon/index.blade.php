@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-4">
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



<!-- Modal Import -->
<div class="modal fade" data-backdrop="static" id="modal_import">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            
            <div class="card-header">
                <h2 class="card-title m-0">Import Code</h2>
            </div>
            <form class="modal-dialog-scrollable" enctype='multipart/form-data' action="{{ url('products/imports') }}" method="POST">
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
