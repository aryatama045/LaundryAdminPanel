
@extends('layouts.app')

@section('content')

<style>

    #tracking {
        background: #fff;
    }
    .tracking-detail {
        padding: 3rem 0;
    }
    #tracking {
        margin-bottom: 1rem;
    }
    [class*="tracking-status-"] p {
        margin: 0;
        font-size: 1.1rem;
        color: #fff;
        text-transform: uppercase;
        text-align: center;
    }
    [class*="tracking-status-"] {
        padding: 1.6rem 0;
    }
    .tracking-list {
        border: 1px solid #e5e5e5;
    }
    .tracking-item {
        border-left: 4px solid #00ba0d;
        position: relative;
        padding: 2rem 1.5rem 0.5rem 2.5rem;
        font-size: 0.9rem;
        margin-left: 3rem;
        min-height: 5rem;
    }
    .tracking-item:last-child {
        padding-bottom: 4rem;
    }
    .tracking-item .tracking-date {
        margin-bottom: 0.5rem;
    }
    .tracking-item .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: 0.4rem;
    }
    .tracking-item .tracking-content {
        padding: 0.5rem 0.8rem;
        background-color: #f4f4f4;
        border-radius: 0.5rem;
    }
    .tracking-item .tracking-content span {
        display: block;
        color: #767676;
        font-size: 13px;
    }
    .tracking-item .tracking-icon {
        position: absolute;
        left: -0.7rem;
        width: 1.1rem;
        height: 1.1rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        background-color: #fff;
        color: #fff;
    }

    .tracking-item-pending {
        border-left: 4px solid #d6d6d6;
        position: relative;
        padding: 2rem 1.5rem 0.5rem 2.5rem;
        font-size: 0.9rem;
        margin-left: 3rem;
        min-height: 5rem;
    }
    .tracking-item-pending:last-child {
        padding-bottom: 4rem;
    }
    .tracking-item-pending .tracking-date {
        margin-bottom: 0.5rem;
    }
    .tracking-item-pending .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: 0.4rem;
    }
    .tracking-item-pending .tracking-content {
        padding: 0.5rem 0.8rem;
        background-color: #f4f4f4;
        border-radius: 0.5rem;
    }
    .tracking-item-pending .tracking-content span {
        display: block;
        color: #767676;
        font-size: 13px;
    }
    .tracking-item-pending .tracking-icon {
        line-height: 2.6rem;
        position: absolute;
        left: -0.7rem;
        width: 1.1rem;
        height: 1.1rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        color: #d6d6d6;
    }
    .tracking-item-pending .tracking-content {
        font-weight: 600;
        font-size: 17px;
    }

    .tracking-item .tracking-icon.status-current {
        width: 1.9rem;
        height: 1.9rem;
        left: -1.1rem;
    }
    .tracking-item .tracking-icon.status-intransit {
        color: #00ba0d;
        font-size: 0.6rem;
    }
    .tracking-item .tracking-icon.status-decline {
        color: red;
        font-size: 0.6rem;
    }
    .tracking-item .tracking-icon.status-current {
        color: #00ba0d;
        font-size: 0.6rem;
    }
    @media (min-width: 992px) {
        .tracking-item {
            margin-left: 10rem;
        }
        .tracking-item .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right;
        }
        .tracking-item .tracking-date span {
            display: block;
        }
        .tracking-item .tracking-content {
            padding: 0;
            background-color: transparent;
        }

        .tracking-item-pending {
            margin-left: 10rem;
        }
        .tracking-item-pending .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right;
        }
        .tracking-item-pending .tracking-date span {
            display: block;
        }
        .tracking-item-pending .tracking-content {
            padding: 0;
            background-color: transparent;
        }
    }

    .tracking-item .tracking-content {
        font-weight: 600;
        font-size: 17px;
    }

    .blinker {
        border: 7px solid #e9f8ea;
        animation: blink 1s;
        animation-iteration-count: infinite;
    }
    @keyframes blink {
        50% {
            border-color: #fff;
        }
    }

</style>

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
                                @role('root')
                                <tr>
                                    <th>{{ __('Customer') }}</th>
                                    <td>{{ $klaim->user->name }} </td>
                                </tr>
                                @endrole

                                <tr>
                                    <th>{{ __('No Nota') }}</th>
                                    <td>{{ $klaim->no_nota }} <br> <small>Tanggal nota : <?php echo date('d-m-Y', strtotime($klaim->tanggal_nota)) ?></small></td>
                                </tr>
                                <tr>
                                    <th>{{ __('No Pemasangan') }}</th>
                                    <td>{{ $klaim->no_pemasangan }} <br> <small>Tanggal pemasangan : <?php echo date('d-m-Y', strtotime($klaim->tanggal_pemasangan)) ?></small></td>
                                </tr>

                                <tr>
                                    <th>{{ __('Status') }}</th>
                                    <td><span class="badge badge-success">{{ $klaim->status }} </span></td>
                                </tr>

                                @if (!$klaim->bukti_foto->isEmpty())
                                <tr>
                                    <th>{{ __('Bukti Foto') }}</th>
                                    <td>
                                        @foreach ($klaim->bukti_foto as $key => $bukti)
                                        <div>
                                            {!! $key == 0 ? ' <hr class="my-2">' : '' !!}

                                            @php
                                                $server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');
                                            @endphp

                                            <span>View </span>

                                            <a href="#bukti_foto_show_{{ $bukti->id }}" data-toggle="modal" class="btn btn-info p-1 px-2 ml-2">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <hr class="my-2">
                                            <!-- Modal -->
                                            <div class="modal fade" id="bukti_foto_show_{{ $bukti->id }}">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $klaim->no_pemasangan }}</h5>
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

                                                                @role('root')
                                                                <tr>
                                                                    <td>{{ __('Kode Foto') }}</td>
                                                                    <td>{{ $bukti->kode_foto }}</td>
                                                                </tr>
                                                                @endrole

                                                                @role('customer')
                                                                <tr>
                                                                    <td>{{ __('Kode Foto') }}</td>
                                                                    <td>{{ $bukti->src }}</td>
                                                                </tr>
                                                                @endrole

                                                                <tr>
                                                                    <td>{{ __('No Nota') }}</td>
                                                                    <td>{{ $klaim->no_nota }} <br> <small> Tanggal : {{ date('d-m-Y', strtotime($klaim->tanggal_nota)) }} </small></td>
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

                                <tr>
                                    <td colspan="2">
                                        @foreach ($klaim->bukti_foto as $key => $bukti)

                                        @endforeach

                                        <div class="container py-5">

                                            <div class="row">

                                                <div class="col-md-12 col-lg-12">

                                                    <div id="tracking-pre"></div>

                                                    <div id="tracking">

                                                        <div class="tracking-list">

                                                            @if ($klaim->status == 'Proses')
                                                            <div class="tracking-item-pending">
                                                            @elseif($klaim->status == 'Diterima' || $klaim->status == 'Ditolak' || $klaim->status == 'Disetujui')
                                                            <div class="tracking-item">
                                                            @endif
                                                                <div class="tracking-icon status-intransit">
                                                                    <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                                    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                                    </svg>
                                                                </div>
                                                                <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
                                                                <div class="tracking-content"> Proses </div>
                                                            </div>


                                                            @if ($klaim->status == 'Proses')
                                                            <div class="tracking-item-pending">
                                                            @elseif($klaim->status == 'Diterima' || $klaim->status == 'Ditolak' || $klaim->status == 'Disetujui')
                                                            <div class="tracking-item">
                                                            @endif
                                                                <div class="tracking-icon status-intransit">
                                                                    <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                                    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                                    </svg>
                                                                </div>
                                                                <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
                                                                <div class="tracking-content">Status Diterima </div>
                                                            </div>

                                                            @if($klaim->status == 'Ditolak')
                                                            <div class="tracking-item">


                                                                    <div class="tracking-icon status-intransit">
                                                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="tracking-date">
                                                                        <svg style="width:23%" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                                                            <circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle>
                                                                            <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"></line>
                                                                            <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"></line>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="tracking-content"> Ditolak <br> <span>Keterangan : {{$klaim->keterangan}} </span></div>
                                                            </div>
                                                            @endif

                                                            @if($klaim->status == 'Disetujui')
                                                            <div class="tracking-item">


                                                                    <div class="tracking-icon status-intransit">
                                                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="tracking-date"><img src="https://raw.githubusercontent.com/shajo/portfolio/a02c5579c3ebe185bb1fc085909c582bf5fad802/delivery.svg" class="img-responsive" alt="order-placed" /></div>
                                                                    <div class="tracking-content">Disetujui <br> <span>Keterangan : {{$klaim->keterangan}} </div>

                                                            </div>
                                                            @endif



                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </td>
                                </tr>

                                @role('root')
                                <tr>

                                    <td>
                                        <form action="{{ route('klaim.proses_action', $klaim->id) }}" method="POST" enctype="multipart/form-data"> @csrf
                                        <select class="form-control select" name="status">
                                            <option value="Diterima">Diterima</option>
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>

                                        <br><br>
                                        <input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
                                        <hr class="mt-6">
                                        <button class="float-left btn btn-primary">{{ __('Submit') }}</button>

                                    </td>
                                    <td></td>
                                </tr>
                                @endrole


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



