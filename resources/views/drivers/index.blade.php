@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="m-0"> {{ __('Drivers') . ' '.__('List') }}</h2>
                    <div>
                        <a href="{{ route('driver.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('Add_New') . ' '.__('Driver') }}
                        </a>
                        @if (request()->deactive)
                        <a href="{{ route('driver.index') }}" class="btn btn-info">
                            {{ __('Active') . ' '.__('Driver') }}
                        </a>
                        @else
                        <a href="{{ route('driver.index','deactive=1') }}" class="btn btn-danger">
                            {{ __('Inactive') . ' '.__('Driver') }}
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm {{ session()->get('local') }}" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('No') }}</th>
                                    <th scope="col">{{ __('Driver') . ' '.__('Name') }}</th>
                                    <th scope="col">{{ __('Register_Date') }}</th>
                                    <th scope="col">{{ __('Email_Address') }}</th>
                                    <th scope="col">{{ __('Phone_number') }}</th>
                                    @if (request()->deactive)
                                        <th scope="col">{{ __('Active') . ' '.__('Status') }}</th>
                                    @else
                                    <th scope="col">{{ __('Approve') }}</th>
                                    @endif
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                @foreach ($drivers as $driver)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$driver->user->name}}</td>
                                    <td>{{$driver->user->created_at->format('d M, Y')}}</td>
                                    <td>{{$driver->user->email}}</td>
                                    <td>{{$driver->user->mobile}}</td>
                                    @if (request()->deactive)
                                        <td>
                                            <label class="switch">
                                                <a href="{{ route('user.status.toggle', $driver->user->id) }}">
                                                    <input {{ $driver->user->is_active ? 'checked':'' }} type="checkbox">
                                                    <span class="slider round"></span>
                                                </a>
                                            </label>
                                        </td>
                                    @else
                                        <td>
                                            <label class="switch">
                                                <a href="{{ route('driver.status.toggle', $driver->id) }}">
                                                    <input {{ $driver->is_approve ? 'checked':'' }} type="checkbox">
                                                    <span class="slider round"></span>
                                                </a>
                                            </label>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{ route('driver.details', $driver->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
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
