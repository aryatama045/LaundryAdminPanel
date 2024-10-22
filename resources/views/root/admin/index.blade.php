@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card px-4 pb-2">
                <div class="card-header py-2 d-flex align-items-center justify-content-between mb-3">
                    <h2 class="card-title m-0">{{ __('All Admins') }}</h2>
                    <div class="d-flex justify-content-end" >
                        <a href="{{ route('admin.create') }}" class="btn btn-primary">{{ __('Create New Admin') }}</a>
                    </div>
                </div>

                <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Email') }}</th>
                            <th scope="col">{{ __('Mobile') }}</th>
                            <th scope="col">{{ __('Gender') }}</th>
                            <th scope="col">{{ __('Created At') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col" class="px-2">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->mobile }}</td>
                            <td>{{ $admin->gender ?? '--' }}</td>
                            <td>{{ $admin->created_at->format('M d, Y') }}</td>
                            <td>
                                <label class="switch">
                                    <a @role('visitor') class="visitorMessage" @else href="{{ route('admin.status-update', $admin->id) }}" @endrole>
                                        <input type="checkbox" {{ $admin->is_active ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </a>
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-danger py-1 px-2">{{ __('Edit') }}</a>
                                <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-primary py-1 px-2">{{ __('Permissions') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
