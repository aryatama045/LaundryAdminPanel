@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Contacts') . ' '.__('List') }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('No') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Photo') }}</th>
                                    <th scope="col">{{ __('Message') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$contact->name}}</td>
                                    <td>{{$contact->phone_number}}</td>
                                    <td>{{$contact->message}}</td>
                                    <td>{{$contact->email}}</td>
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
