@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#AddSubProduct">
                <i class="fa fa-plus"></i> {{ __('Add New Sub Product') }}
            </button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                        <h3 class="m-0">All sub products under {{ $product->name }} product</h3>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="myTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->subProducts as $subProduct)
                                        <tr>
                                            <td>{{ $subProduct->name }}</td>
                                            <td>
                                                {{ currencyPosition($subProduct->price ? $subProduct->price : '00') }}
                                            </td>
                                            <td>
                                                {{ $subProduct->description }}
                                            </td>

                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#EditSubProduct{{ $subProduct->id }}">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="EditSubProduct{{ $subProduct->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('Edit Sub Product') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('product.subproduct.update', $subProduct->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @method('put')
                                                        @csrf
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label
                                                                    for="">{{ __('Product') . ' ' . __('Name') }}</label>
                                                                <input class="form-control" type="text" name="name"
                                                                    placeholder="Product Name" value="{{ $subProduct->name }}"
                                                                    required />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Price</label>
                                                                <input class="form-control" type="text" name="price"
                                                                    placeholder="Price Add..."
                                                                    value="{{ $subProduct->price }}" required />
                                                            </div>
                                                            <div>
                                                                <label for="">Description</label>
                                                                <textarea class="form-control" name="description" rows="3">
                                                                {{ $subProduct->description }}
                                                            </textarea>
                                                            </div>
                                                            <input type="hidden" name="variant_id"
                                                                value="{{ $subProduct->variant_id }}" />
                                                            <input type="hidden" name="service_id"
                                                                value="{{ $subProduct->service_id }}" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="AddSubProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Sub Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('product.subproduct.store', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="mb-1">{{ __('Product') . ' ' . __('Name') }}</label>
                        <x-input name="name" type="text" placeholder="{{ __('Product') . ' ' . __('Name') }}" />

                        <label class="mb-1">{{ __('Product') . ' ' . __('Price') }}</label>
                        <input name="price" type="text" class="form-control"
                            placeholder="{{ __('Product') . ' ' . __('Price') }}" onkeypress="onlyNumber(event)" />

                        <div>
                            <label class="mb-1 mt-3">{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="{{ __('Description') }}"></textarea>
                        </div>
                        <input type="hidden" name="variant_id" value="{{ $product->variant_id }}" />
                        <input type="hidden" name="service_id" value="{{ $product->service_id }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
