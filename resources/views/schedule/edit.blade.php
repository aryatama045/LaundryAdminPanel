@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-2 bg-primary">
                    <h2 class="card-title m-0 text-white">{{ ucfirst($type) }} Schedules</h2>
                </div>
                <div class="card-body">
                    <div class="col-8 m-auto">
                        <form action="" method="POST"> @csrf @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <label class="mb-1">Start Time</label>
                                    <x-input name="start_time" type="time" value="{{ $start }}"/>
                                </div>

                                <div class="col-12">
                                    <label class="mb-1">End Time</label>
                                    <x-input name="start_time" type="time" value="{{ $end }}"/>
                                </div>

                                <div class="col-12">
                                    <label class="mb-1">Per hour</label>
                                    <x-input name="per_hour" type="number" value="{{ $orderSchedule->per_hour }}"/>
                                </div>

                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary px-5">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
