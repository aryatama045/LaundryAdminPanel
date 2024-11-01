@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center py-2 justify-content-between">
                        <h2 class="card-title m-0">{{ __('All'). ' '.__('Garansi') }}</h2>
                        <div hidden>
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
                                    
                                </ul>
                            </form>
                        </div>

                        @can('customer.create')
                        <a href="{{ route('garansi.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('New'). ' '.__(' Garansi') }}
                        </a>
                        @endcan
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('No. Nota') }}</th>
                                        <th scope="col">{{ __('No. Pemasangan') }}</th>
                                        <th scope="col">{{ __('Masa Berlaku') }}</th>
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
                                                <small> Tgl nota : {{ date('d-m-Y', strtotime($garansi->tanggal_nota)) }} </small>
                                            </td>
                                            <td>
                                                {{ $garansi->no_pemasangan }} <br>
                                                <small> Tgl pemasangan : {{ date('d-m-Y', strtotime($garansi->tanggal_pemasangan)) }} </small>
                                            </td>
                                            <td>
                                                @php
                                                    $dateExp = strtotime('+90 days', strtotime($garansi->tanggal_pemasangan));
                                                    $dateExps = date('d-m-Y', $dateExp);


                                                    $tgl_now = date('d-m-Y');

                                                    if($tgl_now >= $dateExps ){
                                                        $berlaku = now()->diffInDays($dateExps);
                                                    }else{
                                                        $berlaku = 'Expired';
                                                    }
                                                @endphp



                                                <span class="badge badge-primary"> Berlaku : {{ $berlaku }} Hari</span> <br>
                                                <span class="badge badge-warning"> Sampai : {{ $dateExps }} </span>

                                            </td>
                                            
                                            <td>
                                                <a href="{{ route('garansi.show', $garansi->id) }}"
                                                    class="btn btn-primary py-1 px-2">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @canany('customer.edit')
                                                <a href="{{ route('garansi.edit', $garansi->id) }}"
                                                    class="btn btn-info py-1 px-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endcanany

                                                @canany('customer.delete')
                                                <a href="{{ route('garansi.delete', $garansi->id) }}"
                                                    class="btn btn-danger py-1 px-2 delete-confirm" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                @endcanany
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
