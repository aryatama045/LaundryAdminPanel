@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    @php
        $websetting = App\Models\WebSetting::first();
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">{{ __('All').' '.__('Additional_Service') }}</h2>
                    @can('additional.create')
                    <div class="w-100 text-right">
                        <a href="{{ route('additional.create') }}" class="text-right btn btn-primary">{{ __('Create').' '.__('Additional_Service') }}</a>
                    </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm {{ session()->get('local') }}" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Description'). ' ' . __('Arabic') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    @can('additional.status.toggle')
                                    <th scope="col">{{ __('Status') }}</th>
                                    @endcan
                                    @canany(['additional.edit'])
                                    <th style="min-width: 130px" scope="col">{{ __('Action') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($additionals as $additional)
                                <tr>
                                    <td>{{ $additional->title }}</td>
                                    <td>
                                        {{ substr($additional->description, 0 ,25) }}
                                    </td>
                                    <td>{{ currencyPosition($additional->price) }}</td>
                                    @can('additional.status.toggle')
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('additional.status.toggle', $additional->id) }}">
                                                <input {{ $additional->is_active ? 'checked':'' }} type="checkbox">
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    @endcan
                                    @can(['additional.edit'])
                                    <td>
                                        <span>
                                            <a href="{{ route('additional.edit', $additional->id) }}" class="btn btn-sm btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </span>
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
