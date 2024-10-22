@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-2 bg-primary">
                    <h2 class="card-title m-0 text-white">{{ __(ucfirst($type)) }} {{ __('Schedules') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped {{ session()->get('local') }}" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Day') }}</th>
                                    <th scope="col">{{ __('Start at') }}</th>
                                    <th scope="col">{{ __('End at') }}</th>
                                    <th scope="col">{{ __('Per Hour') }}</th>
                                    <th scope="col">{{ __('Off Day') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ __($schedule->day) }}</td>
                                    <td>{{ $schedule->start_time }}:00</td>
                                    <td>{{ $schedule->end_time }}:00</td>
                                    <td>{{ $schedule->per_hour }}</td>
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('toggole.status.update', $schedule->id) }}">
                                                <input type="checkbox" {{ !$schedule->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#schedule_{{ $schedule->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="schedule_{{ $schedule->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLabel">{{ __('Update') }} {{ __($schedule->day).' '.__('Schedule') }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('schedule.update', $schedule->id) }}" method="POST"> @csrf @method('put')
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="mb-1">{{ __('Start Time') }}</label>
                                                                @php
                                                                    $start = sprintf("%02s", $schedule->start_time) . ':00';
                                                                    $end = sprintf("%02s", $schedule->end_time) . ':00';
                                                                @endphp
                                                                <x-input name="start_time" type="time" value="{{ $start }}"/>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="mb-1">{{ __('End Time') }}</label>
                                                                <x-input name="end_time" type="time" value="{{ $end }}"/>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="mb-1">{{ __('Per Hour') }}</label>
                                                                <x-input name="per_hour" type="number" value="{{ $schedule->per_hour }}"/>
                                                            </div>

                                                            <div class="col-12 text-right">
                                                                <button type="button" data-dismiss="modal" class="btn btn-secondary px-5">{{ __('Cancel') }}</button>
                                                                <button type="submit" class="btn btn-primary px-5">{{ __('Update') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
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
