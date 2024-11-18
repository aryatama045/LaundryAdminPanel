@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">{{ __('App_Banners') }}</h2>
                    @can('banner.store')
                    <div class="w-100 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                            {{ __('Add_New'). ' '.__('Banner') }}
                        </button>
                    </div>

                    <div class="modal fade" id="createModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="exampleModalLabel">{{ __('Add_New'). ' '.__('Banner') }}</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @role('root|admin') action="{{ route('banner.store') }}" @endrole method="POST" enctype="multipart/form-data"> @csrf
                                <div class="modal-body">
                                    <label class="mb-1">{{ __('Banner'). ' '.__('Title') }}</label>
                                    <x-input name='title' type="text" placeholder="{{ __('Banner'). ' '.__('Title') }}" />

                                    <label class="mb-1">{{ __('Banner'). ' '.__('Photo') }}</label>
                                    <x-input-file name="image" type="file"/>

                                    <label class="mb-1">{{ __('Banner'). ' '.__('Description') }}</label>
                                    <x-textarea name="description" placeholder="{{ __('Banner'). ' '.__('Description') }}" />

                                    <div class="form-group">
                                        <label for="active">
                                            <input type="radio" id="active" name="active" value="1"> {{ __('Active') }}
                                        </label>
                                        <label for="in_active" class="ml-3">
                                            <input type="radio" id="in_active" name="active" value="1"> {{ __('Inactive') }}
                                        </label>
                                    </div>

                                    <div hidden class="form-group">
                                        <label for="banner">
                                            <input type="checkbox" id="banner" class="form-control-checkbox" name="banner" value="1"> {{ __('Web'). ' '.__('Banner') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary @role('visitor')visitorMessage @endrole">{{ __('Save_changes') }}</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div> {{-- Modal End --}}
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped verticle-middle table-responsive-sm {{ session()->get('local') }}">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Image') }}</th>
                                    @can('banner.status.toggle')
                                    <th scope="col">{{ __('Status') }}</th>
                                    @endcan
                                    @canany(['banner.destroy', 'banner.edit'])
                                    <th scope="col">{{ __('Action') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        {{ substr($banner->description, 0 ,30) }}
                                    </td>
                                    <td>
                                        @php
                                            $ext = asset($banner->thumbnailPath)->extension();
                                            dd($ext);
                                        @endphp
                                        <img width="100" src="{{ asset($banner->thumbnailPath) }}" alt="">
                                    </td>
                                    @can('banner.status.toggle')
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('banner.status.toggle', $banner->id) }}">
                                                <input type="checkbox" {{ $banner->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    @endcan
                                    @canany(['banner.destroy', 'banner.edit'])
                                    <td>
                                        @can('banner.edit')
                                        <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-sm btn-primary">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('banner.destroy')
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal_{{ $banner->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        <div class="modal fade" id="deleteModal_{{ $banner->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="exampleModalLabel">Delete a banner</h2>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                    <div class="modal-body">
                                                        <h3 class="text-warning">Are you sure?</h3>
                                                        <h5>You want to permanently delete this banner.</h5>
                                                        <img width="30%" src="{{ $banner->thumbnailPath }}" alt="">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        @role('visitor')
                                                        <button type="button" class="btn btn-danger visitorMessage">Delete</button>
                                                        @else
                                                        <form action="{{ route('banner.destroy', $banner->id) }}" method="POST">
                                                            @csrf @method('delete')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                        @endrole
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  {{-- Modal End --}}
                                        @endcan
                                    </td>
                                    @endcanany
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
