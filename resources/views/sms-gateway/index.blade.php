@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-xl-9 col-xxl-9 col-lg-9 mt-2 mx-auto ">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title m-0">SMS Configuration <a class="text-info" href="https://www.mobivate.com/bulk-sms/mobile-marketing-costs" target="__blanck">Click To Go</a></h2>
                    </div>

                    <div class="card-body">
                        <x-form route="sms-gateway.update" :method="true" type="Submit">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="mb-1"><b>URL</b> <small>(ex. https://app.mobivatebulksms.com/gateway/api/simple/MT)</small></label>
                                    <x-input :value="config('app.sms_base_url')" name="url" type="text" placeholder="URL" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="mb-1"><b>User Name</b></label>
                                    <x-input :value="config('app.sms_user_name')" name="user_name" type="text" placeholder="User Name" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-1"><b>Password</b></label>
                                    <x-input :value="config('app.sms_password')" name="password" type="text" placeholder="Password" required/>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="mb-1"><b>Originator</b></label>
                                    <x-input :value="config('app.sms_originator')" name="originator" type="text" placeholder="Originator" required/>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="mb-1"><b>Route</b></label>
                                    <x-input :value="config('app.sms_route')" name="route" type="text" placeholder="Route" />
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
