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
                                    <li class="nav-item ml-2 mr-md-0">
                                        <x-input type="text" name='search' placeholder="Search" value="{{ request('search') }}" />
                                    </li>
                                    <li class="nav-item ml-2 mr-md-0">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-search"></i>
                                    </button>
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
                                    <th scope="col">{{ __('Name').' '.__('of'). ' '. __('English') }}</th>
                                    <th scope="col">{{ __('Name').' '.__('of'). ' '. __('Arabic') }}</th>
                                    <th scope="col">{{ __('Thumbnail') }}</th>
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
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->name_bn ?? 'N\A' }}</td>
                                    <td>
                                        <img width="100" src="{{ $product->thumbnailPath }}" alt="">
                                    </td>
                                    <td>{{  session()->get('local') == 'ar' ? $product->variant->name_bn ??$product->variant->name : $product->variant->name }}</td>
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
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="{{ route('product.subproduct.index', $product->id) }}" class="btn btn-sm btn-primary">
                                           Sub Products
                                        </a>

                                        <a href="{{ route('product.delete', $product->id) }}" class="btn btn-sm btn-danger delete-confirm"><i class="fas fa-trash"></i></a>
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
