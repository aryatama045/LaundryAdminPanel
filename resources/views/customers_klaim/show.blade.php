
@extends('layouts.app')

@section('content')

<?php include('tracking.css') ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">{{ __('Klaims').' '.__('Details') }}</h2>
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
                                    <th>{{ __('No Nota') }}</th>
                                    <td>{{ $garansi->no_nota }} <small>Tanggal : <?php echo date('d-m-Y', strtotime($garansi->tanggal_nota)) ?></small></td>
                                </tr>
                                <tr>
                                    <th>{{ __('No Pemasangan') }}</th>
                                    <td>{{ $garansi->no_pemasangan }} <small>Tanggal : <?php echo date('d-m-Y', strtotime($garansi->tanggal_pemasangan)) ?></small></td>
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
                                                                    <td>{{ $garansi->no_nota }} <br> <small> Tanggal : {{ date('d-m-Y', strtotime($garansi->tanggal_nota)) }} </small></td>
                                                                </tr>

                                                                <tr>
                                                                    <?php
                                                                        $get_media = DB::table('media')->where('id', $bukti->foto_id)->first();
                                                                    ?>

                                                                    <td colspan="2">
                                                                        <img width="100%" src="{{ Storage::url($get_media->path);  }}" alt="{{ $bukti->kode_foto }}">
                                                                    </td>

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




<div class="container py-5">

    <div class="row">

        <div class="col-md-12 col-lg-12">

            <div id="tracking-pre"></div>

            <div id="tracking">

                <div class="tracking-list">

                    <div class="tracking-item">
                        <div class="tracking-icon status-intransit">
                            <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                        </div>
                        <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
                        <div class="tracking-content">Order Placed<span>09 Aug 2025, 10:00am</span></div>
                    </div>

                    <div class="tracking-item-pending">
                        <div class="tracking-icon status-intransit">
                            <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                            </svg>
                        </div>
                        <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
                        <div class="tracking-content">Delivered<span>12 Aug 2025, 09:00pm</span></div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
