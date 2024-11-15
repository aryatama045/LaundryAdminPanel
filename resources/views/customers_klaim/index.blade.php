@extends('layouts.app')

@section('content')

@php
$server  = request()->userAgent();

@endphp

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center py-2 justify-content-between">
                        <h2 class="card-title m-0">{{ __('All'). ' '.__('Klaims') }}</h2>
                        <a href="{{ route('klaim.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('New'). ' '.__(' Klaims') }}
                        </a>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                                <thead>
                                    <tr>
                                        @role('root')
                                        <th scope="col">{{ __('Name') }}</th>
                                        @endrole
                                        <th scope="col">{{ __('No. Tracking') }}</th>
                                        <th scope="col">{{ __('No. Nota') }}</th>
                                        <th scope="col">{{ __('No. Pemasangan') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($dataklaims))
                                    @foreach ($dataklaims as $klaims)
                                        <tr>
                                            @role('root')
                                            <td>{{ $klaims->user->name }}</td>
                                            @endrole
                                            <td>
                                                {{ $klaims->no_tracking }}
                                            </td>

                                            <td>
                                                {{ $klaims->no_nota }} <br>
                                                <small> Tgl nota : {{ $klaims->tanggal_nota }} </small>
                                            </td>
                                            <td>
                                                {{ $klaims->no_pemasangan }} <br>
                                                <small> Tgl pemasangan : {{ $klaims->tanggal_pemasangan }} </small>
                                            </td>
                                            <td>
                                                @if($klaims->status == 'Disetujui')
                                                    <span class="badge badge-success">{{ $klaims->status }} </span>
                                                @elseif($klaims->status == 'Ditolak')
                                                    <span class="badge badge-danger">{{ $klaims->status }} </span>
                                                @elseif($klaims->status == 'Diterima')
                                                    <span class="badge badge-grey">{{ $klaims->status }} </span>
                                                @else
                                                <span class="badge badge-info">{{ $klaims->status }} </span>
                                                @endif

                                            </td>
                                            <td>
                                                @role('root')
                                                <a href="{{ route('klaim.proses', $klaims->id) }}"
                                                    class="btn btn-primary py-1 px-2">
                                                    Proses
                                                </a>
                                                @endrole

                                                @role('customer')
                                                <a href="{{ route('klaim.show', $klaims->id) }}"
                                                    class="btn btn-primary py-1 px-2">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endrole


                                                {{-- <a href="{{ route('klaim.edit', $klaims->id) }}"
                                                    class="btn btn-info py-1 px-2">
                                                    <i class="fa fa-edit"></i>
                                                </a> --}}
                                                <a href="{{ route('klaim.delete', $klaims->id) }}"
                                                    class="btn btn-danger py-1 px-2 delete-confirm" >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
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
