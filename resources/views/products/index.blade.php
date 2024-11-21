@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h2 class="card-title float-left">{{ __('All').' '.__('Products') }}</h2>
                        </div>

                        <div class="col-md-8">
                            <form action="{{ route('product.index') }}" method="GET">
                                <ul class="nav nav-pills justify-content-end">
                                    <!-- <li class="nav-item ml-2 mr-md-0">
                                        <x-input type="text" name='search' placeholder="Search" value="{{ request('search') }}" />
                                    </li>
                                    <li class="nav-item ml-2 mr-md-0">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </li> -->
                                    <li class="nav-item ml-2 mr-md-0">
                                        <a class="btn btn-info" data-effect="effect-super-scaled"
                                            data-toggle="modal" href="#modal_import">
                                            <i class="fa fa-upload"></i> Import
                                        </a>
                                    </li>
                                    @can('product.create')
                                    <li class="nav-item ml-2 mr-md-0">
                                        <a href="{{ route('product.create') }}" class="btn btn-primary">
                                            {{__('Add_New').' '.__('Product')}}
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Thumbnail') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('SKU') }}</th>
                                    <th scope="col">{{ __('Variant') }}</th>
                                    <th scope="col">{{ __('Discount').' '.__('Price') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    @can('product.status.toggle')
                                    <th scope="col">{{ __('Status') }}</th>
                                    @endcan
                                    @can('product.edit')
                                    <th scope="col">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <img width="100" src="{{ $product->thumbnailPath }}" alt="">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->variant->name }}</td>
                                    <td>
                                        @if ($product->discount_price)
                                        {{ currencyPosition($product->discount_price) }}
                                        @else
                                        <del>{{ currencyPosition('00') }}</del>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->discount_price)
                                        <del>{{ currencyPosition($product->price ? $product->price : '00')  }}</del>
                                        @else
                                            {{ currencyPosition($product->price ? $product->price : '00')  }}
                                        @endif
                                    </td>
                                    <td>
                                        {{$product->description}}
                                    </td>
                                    @can('product.status.toggle')
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('product.status.toggle', $product->id) }}">
                                                <input type="checkbox" {{ $product->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    @endcan
                                    @can('product.edit')
                                    <td>
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-primary" title="View">
                                            <i class="far fa-eye"></i>
                                        </a>

                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="{{ route('product.delete', $product->id) }}" class="btn btn-sm btn-danger delete-confirm" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <br>
                                        <a href="{{ route('product.subproduct.index', $product->id) }}" class="btn btn-sm btn-primary">
                                            Sub Products
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



<!-- Modal Import -->
<div class="modal fade" data-backdrop="static" id="modal_import">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">

            <div class="card-header">
                <h2 class="card-title m-0">Import</h2>
            </div>
            <form class="modal-dialog-scrollable" enctype='multipart/form-data' action="{{url('products/imports')}}" method="POST">
            @csrf
            <div class="card-body">
                <!--<a class="btn btn-danger" onclick="pdf()"><i class="fa fa-file-pdf-o"></i> PDF</a>-->
                <!--<br><br>-->
                <!--<hr>-->
                <!--<br><br>-->

                <div class="form-group">
                    <label class="mb-1">{{ __('Import') . ' ' . __('Excel') }}</label>
                    <x-input-file name="import_data" type="file" />
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>




                <a href="javascript:void(0)" class="btn btn-warning" onclick="reset()" data-dismiss="modal">Batal <i class="fas fa-x"></i></a>

                <button type="submit" class="btn btn-success"><i class="fas fa-file-excel-o"></i> Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
