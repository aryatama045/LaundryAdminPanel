@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left my-1">{{ __('All'). ' '. __('Service') }}</h2>
                    <div class="w-100 text-right">
                        @can('additional.index')
                        <a href="{{ route('additional.index') }}" class="text-right btn btn-info my-md-0 my-1">{{ __('Additional_Services') }}</a>
                        @endcan
                        @can('service.create')
                        <a href="{{ route('service.create') }}" class="text-right btn btn-primary my-md-0 my-1">{{ __('Add_New'). ' '. __('Service') }}</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm {{ session()->get('local') }}" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Thumbnail') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    @can('service.status.toggle')
                                    <th scope="col">{{ __('Status') }}</th>
                                    @endcan
                                    @canany(['service.edit'])
                                    <th style="min-width: 130px" scope="col">{{ __('Action') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    <td>
                                        <img width="100" src="{{ asset($service->thumbnailPath) }}" alt="">
                                    </td>
                                    <td>
                                        {{ substr($service->description, 0 ,25) }}
                                    </td>
                                    @can('service.status.toggle')
                                    <td>
                                        <label class="switch @role('visitor') visitorMessage @endrole">
                                            <a href="@role('visitor') # @else {{ route('service.status.toggle', $service->id) }} @endrole">
                                                <input {{ $service->is_active ? 'checked':'' }} type="checkbox">
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    @endcan

                                    @can('service.edit')
                                    <td>
                                        <a href="{{ route('service.edit', $service->id) }}" class="btn btn-sm btn-primary">
                                            <i class="far fa-edit"></i>
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
