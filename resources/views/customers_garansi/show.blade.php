

@extends('layouts.app')

@section('content')
@php
    $server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');
@endphp

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
                                    <th scope="col">{{ __('Detail') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th>{{ __('Customer') }}</th>
                                    <?php
                                        $customer = DB::table('users')->where('id', $garansi->customer_id)->first();
                                    ?>
                                    <td>{{ $customer->first_name.' '. $customer->last_name }} ({{ $customer->company }})</td>
                                </tr>

                                <tr>
                                    <th>{{ __('No Nota') }}</th>
                                    <td>{{ $garansi->no_nota }} <br>
                                        <small>Tanggal : <?php echo date('d-m-Y', strtotime($garansi->tanggal_nota)) ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Pemasangan') }}</th>
                                    <td>
                                        <small>Tanggal : <?php echo date('d-m-Y', strtotime($garansi->tanggal_pemasangan)) ?></small><br>
                                        <small>Waktu : <?php echo date('h:i:s', strtotime($garansi->waktu_pemasangan)) ?></small>
                                    </td>
                                </tr>

                                @if (!$garansi->bukti_foto->isEmpty())
                                <tr>
                                    <th>{{ __('Bukti Foto') }}</th>
                                    <td>
                                        @foreach ($garansi->bukti_foto as $key => $bukti)
                                        <div>
                                            {!! $key == 0 ? ' <hr class="my-2">' : '' !!}

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
                                                                @role('root')
                                                                <tr>
                                                                    <td>{{ __('Kode Foto') }}</td>
                                                                    <td>{{ $bukti->kode_foto }}</td>
                                                                </tr>
                                                                @endrole

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


                                <tr>

                                    <td>
                                        <form action="{{ route('garansi.proses_action', $order->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <select class="form-control select" name="status">
                                                <option value="Disetujui">Disetujui</option>
                                                <option value="Ditolak">Ditolak</option>
                                            </select>

                                            <br><br>
                                            <!-- <input type="text" class="form-control" name="keterangan" placeholder="Keterangan"> -->
                                            <hr class="mt-6">
                                            <button class="float-left btn btn-primary">{{ __('Submit') }}</button>
                                        </form>

                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
