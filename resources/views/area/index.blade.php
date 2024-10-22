@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-primary py-2 align-items-center">
                <h2 class="card-title m-0 text-white">{{ __('Area'). ' '.__('List') }}</h2>
                <button class="btn btn-white" data-toggle="modal" data-target="#addAreaModal">{{ __('Add_New'). ' '.__('Area') }}</button>
            </div>

            <div class="card-body">
                <table class="table table-bordered {{ session()->get('local') }}" id="myTable">
                    <thead class="bg-secondary">
                        <tr>
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $index => $area)
                            <tr>
                                <td> {{ $index+1 }}</td>
                                <td> {{ $area->name }}</td>
                                <td>
                                    <label class="switch">
                                        <a href="{{ route('areas.toggle', $area->id) }}">
                                            <input type="checkbox" {{ $area->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </a>
                                    </label>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#editsocial{{ $area->id }}"><i class="fas fa-edit"></i></button>
                                    <a href="{{ route('areas.delete', $area->id) }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="editsocial{{ $area->id }}">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary py-2">
                                            <h4 class="modal-title text-white">{{ __('Edit'). ' '.__('Area') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('areas.update', $area->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="mb-0">{{ __('Area'). ' '.__('Name') }}</label>
                                                    <input type="text" name="name" value="{{ $area->name }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer py-2">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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

    <!-- Modal -->
    <div class="modal fade" id="addAreaModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary py-2">
                    <h4 class="modal-title text-white">{{ __('Add_New'). ' '.__('Area') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('areas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mb-0">{{ __('Area'). ' '.__('Name') }}</label>
                            <input type="text" name="name" placeholder="{{ __('Area'). ' '.__('Name') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
