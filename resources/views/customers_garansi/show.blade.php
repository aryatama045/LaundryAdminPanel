@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">{{ __('Garansi').' '.__('Details') }}</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ url()->previous() }}"> {{ __('Back') }} </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Details') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $garansi->user->first_name ? $garansi->user->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Profile_Photo') }}</th>
                                <td>
                                    <img width="100" src="{{ $garansi->user->profilePhotoPath }}" alt="{{ $garansi->user->name }}">
                                </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <td>
                                        {{ $garansi->user->email }}
                                        @if ($garansi->user->email_verified_at)
                                            <span class="bg-success btn py-0 px-1">{{ $garansi->user->email_verified_at->format('M d, Y') }}</span>
                                            @else
                                            <span class="bg-warning btn py-0 px-1">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Mobile') }}</th>
                                    <td>
                                        {{ $garansi->user->mobile }}
                                        @if ($garansi->user->mobile_verified_at)
                                            <span class="bg-success btn py-0 px-1">{{ __('verified') }}</span>
                                            @else
                                            <span class="bg-warning btn py-0 px-1">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                </tr>


                                @if (!$garansi->bukti_foto->isEmpty())
                                <tr>
                                    <th>{{ __('Bukti Foto') }}</th>
                                    <td>
                                        @foreach ($garansi->bukti_foto as $key => $bukti)
                                        <div>
                                            {!! $key == 0 ? ' <hr class="my-2">' : '' !!}

                                            <span>{{ $bukti->kode_foto }}</span>

                                            <a href="#bukti_foto_show_{{ $bukti->id }}" data-toggle="modal" class="btn btn-info p-1 px-2 ml-2">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <hr class="my-2">
                                            <!-- Modal -->
                                            <div class="modal fade" id="bukti_foto_show_{{ $bukti->id }}">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $garansi->no_pemasangan }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="col">{{ __('Title') }}</th>
                                                                    <th scope="col">{{ __('Details') }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('Kode Foto') }}</td>
                                                                    <td>{{ $bukti->kode_foto }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('No Nota') }}</td>
                                                                    <td>{{ $garansi->no_nota }} <br> <small> Tanggal : {{ $garansi->tanggal_nota_nota }} </small></td>
                                                                </tr>

                                                                <tr>
                                                                    <img width="100" src="{{ $garansi->bukti_foto->getBuktiFotoPathGaransi }}" alt="{{ $garansi->kode_foto }}">

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
