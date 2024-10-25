@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center py-2 justify-content-between">
                        <h2 class="card-title m-0">{{ __('All'). ' '.__('Customers Garansi') }}</h2>
                        <div>
                            <form action="{{ route('garansi.index') }}" method="GET">
                                <ul class=" nav d-flex justify-content-end">
                                    <li class="nav-item ml-2 mr-md-0">
                                        <input type="text" name='search' placeholder="Search"
                                            value="{{ request('search') }}" class="form-control" />
                                    </li>
                                    <li class="nav-item ml-2 mr-md-0">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </li>
                                    @can('customer.create')
                                    <li class="nav-item ml-2 mr-md-0">
                                        <a href="{{ route('garansi.create') }}" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> {{ __('New'). ' '.__('Customer Garansi') }}
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </form>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('No. Nota') }}</th>
                                        <th scope="col">{{ __('No. Pemasangan') }}</th>
                                        @canany(['customer.show', 'customer.edit'])
                                        <th scope="col">{{ __('Action') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($garansis as $garansi)
                                        <tr>
                                            <td>{{ $garansi->user->name }}</td>
                                            <td>
                                                {{ $garansi->no_nota }} <br>
                                                <small> Tgl nota : {{ $garansi->tanggal_nota }} </small>
                                            </td>
                                            <td>
                                                {{ $garansi->no_pemasangan }} <br>
                                                <small> Tgl nota : {{ $garansi->tanggal_pemasangan }} </small>
                                            </td>
                                            @canany(['customer.show', 'customer.edit'])
                                            <td>
                                                <a href="{{ route('garansi.show', $garansi->id) }}"
                                                    class="btn btn-primary py-1 px-2">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('garansi.edit', $garansi->id) }}"
                                                    class="btn btn-info py-1 px-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>
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
    <style>
        td {
            padding: 5px 10px !important;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00B894',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>
@endpush