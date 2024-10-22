@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-primary py-2 align-items-center">
                <h2 class="card-title m-0 text-white">{{ __('All Social Link') }}</h2>
                <button class="btn btn-white" data-toggle="modal" data-target="#addsocialModal">{{ __('Add Social Link') }}</button>
            </div>

            <div class="card-body">
                <table class="table table-bordered {{ session()->get('local') }}" id="myTable">
                    <thead class="bg-secondary">
                        <tr>
                            <th>{{ __('SL.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Url') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    @php
                        $i = 1;
                    @endphp
                    <tbody>
                       @foreach ($socialLink as $link )
                       <tr>
                            <td> {{ $i++ }}</td>
                            <td> {{ $link->name }}</td>
                            <td> <img src="{{ $link->photoPath }}" alt="{{ $link->name }}" width="50"></td>
                            <td> {{ $link->url }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editsocial{{$link->id}}"><i class="fas fa-edit"></i></button>
                                <a href="{{ route('socialLink.delete', $link->id) }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Modal -->
                            <div class="modal fade" id="editsocial{{$link->id}}">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary py-2">
                                            <h4 class="modal-title text-white">{{ __('Edit Social Link') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('socialLink.update', $link->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="mb-0">{{ __('Social Name') }}</label>
                                                    <input type="text" name="name" value="{{ $link->name }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="mb-0 d-block">{{ __('Social Link Photo') }}</label>
                                                    <img src="{{ $link->photoPath }}" alt="{{ $link->name }}" width="50">
                                                    <input type="file" name="photo" class="form-control-file mt-2">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label class="mb-0">{{ __('Social Link URL') }}</label>
                                                    <textarea name="url" class="form-control" rows="2" required>{{ $link->url }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer py-2">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary @role('visitor') visitorMessage @endrole">{{ __('Update') }}</button>
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
        <div class="modal fade" id="addsocialModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary py-2">
                        <h4 class="modal-title text-white">{{ __('Add New Social Link') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('socialLink.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="mb-0">{{ __('Social Name') }}</label>
                                <input type="text" name="name" placeholder="{{ __('Social Name') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="mb-0">{{ __('Social Link Photo') }}</label>
                                <input type="file" name="photo" class="form-control-file" required>
                            </div>
                            <div class="form-group mb-0">
                                <label class="mb-0">{{ __('Social Link URL') }}</label>
                                <textarea name="url" class="form-control" placeholder="{{ __('Social Link URL') }}" rows="2" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary @role('visitor') visitorMessage @endrole">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $('#exampleModal').on('show.bs.modal', event => {
                var button = $(event.relatedTarget);
                var modal = $(this);
                // Use above variables to manipulate the DOM

            });
        </script>

@endsection
