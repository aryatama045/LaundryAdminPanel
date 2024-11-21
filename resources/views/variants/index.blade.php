@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h2 class="card-title">{{ __('All') . ' ' . __('Variants') }}</h2>
                            </div>

                            @can('variant.store')
                                <div class="col-6 position-relative">
                                    <button data-toggle="modal" data-target="#addNew" class="position-absolute btn btn-primary"
                                        style="right: 1em">
                                        {{ __('Add_New') . ' ' . __('Variant') }}
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped verticle-middle table-responsive-sm {{ session()->get('local') }}"
                                id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name')  }}</th>
                                        @canany(['variant.update', 'variant.products'])
                                            <th scope="col">{{ __('Action') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variants as $variant)
                                        <tr>
                                            <td>{{ $variant->name }}</td>
                                            @canany(['variant.update', 'variant.products'])
                                                <td>
                                                    @can('variant.update')
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#update{{ $variant->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="update{{ $variant->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 class="modal-title" id="exampleModalLabel">
                                                                            {{ __('Edit') . ' ' . __('Variant') }}</h2>
                                                                        <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form
                                                                        @role('root|admin') action="{{ route('variant.update', $variant->id) }}" @endrole
                                                                        method="POST">
                                                                        @csrf @method('put')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label>{{ __('Variant') . ' ' . __('Name') }}</label>
                                                                                <input type="text" name="name"
                                                                                    class="form-control"
                                                                                    value="{{ old('name') ?? $variant->name }}">
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label>{{ __('Position') }}</label>
                                                                                <input type="text" name="position"
                                                                                    class="form-control"
                                                                                    value="{{ old('position') ?? $variant->position }}"
                                                                                    placeholder="{{ __('Position') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{ __('Close') }}</button>
                                                                            <button
                                                                                @role('visitor') type="button" class="btn btn-primary visitorMessage" @else type="submit" class="btn btn-primary" @endrole>{{ __('Save_changes') }}</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endcan

                                                    @can('variant.products')
                                                        <a href="{{ route('variant.products', $variant->id) }}"
                                                            class="btn btn-info">{{ __('Products') }}</a>
                                                    @endcan
                                                </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('variant.store')
        <!-- Modal -->
        <div class="modal fade" id="addNew">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">{{ __('Add') . ' ' . __('Variant') }}</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @role('root|admin') action="{{ route('variant.store') }}" @endrole method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>{{ __('Variant') . ' ' . __('Name')  }}</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="{{ __('Variant') . ' ' . __('Name')  }}">
                            </div>

                            <div class="mb-3">
                                <label>{{ __('Position') }}</label>
                                <input type="text" name="position" class="form-control" value="{{ old('position') }}"
                                    placeholder="{{ __('Position') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                            @role('visitor')
                                <button type="button" class="btn btn-primary visitorMessage">{{ __('Submit') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            @endrole
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
