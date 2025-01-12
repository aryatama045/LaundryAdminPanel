@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                            <div class="col-6">
                                <h2 class="card-title">Create</h2>
                            </div>

                            <div class="col-6 position-relative" >
                                <div class="position-absolute" style="right: 1em" >
                                    <a href="{{ route('coupon.index') }}" class="btn btn-dark"><i class="fa fa-arrow-left"></i>  {{ __('Back') }}</a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-8 m-auto">
                        <form @can('coupon.store') @role('root|admin') action="{{ route('coupon.store') }}" @endrole @endcan method="POST"> @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="mb-1">Code</label>
                                    <x-input name="code" type="text" placeholder="Code"/>
                                </div>


                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6 text-right">
                                            <button type="submit" class="btn btn-primary px-5 ">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
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
