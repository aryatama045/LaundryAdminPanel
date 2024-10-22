@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <form @can('notification.send') action="{{ route('notification.send') }}" @endcan method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-primary py-2">
                            <h3 class="card-title m-0 text-white">{{ __('Send_Notifications') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="mb-1">{{ __('Title') }}</label>
                                <input name="title" class="form-control" rows="4" placeholder="{{ __('Title'). ' '. __('Notification') }}..." />
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label class="mb-1">{{ __('Message') }}</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="{{ __('Notification'). ' '. __('Message') }}..."></textarea>
                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @can('notification.send')
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary">{{ __('Send'). ' '. __('Message') }}</button>
                            </div>
                            @endcan
                            <hr class="my-3">
                            <div class="d-flex justify-content-end align-items-center">
                                <span class="font-weight-600 mr-1">{{ __('Device_Type') }}:</span>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle text-capitalize" type="button"
                                        id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        style="width: 150px">
                                        {{ __(request()->device_type) ?? __('All') }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="triggerId">
                                        <a class="dropdown-item"
                                            href="{{ route('notification.index', 'device_type=all') }}">{{ __('All') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('notification.index', 'device_type=android') }}">{{ __('Android') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('notification.index', 'device_type=ios') }}">{{ __('Ios') }}</a>
                                    </div>
                                </div>
                            </div>
                            @error('customer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="table-responsive-md mt-2">
                                <table class="table table-bordered table-striped table-hover  notification_table">
                                    <thead>
                                        <tr>
                                            <th class="px-0 text-center" style="width: 42px">
                                                <input type="checkbox" onclick="toggle(this);" />
                                            </th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Phone_number') }}</th>
                                            <th>{{ __('Email') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @can('notification.send')
                                            @foreach ($customers as $customer)
                                                <tr>
                                                    <td class="py-2 px-0 text-center">
                                                        <input type="checkbox" name="customer[]" value="{{ $customer->id }}">
                                                    </td>
                                                    <td class="py-2">{{ $customer->user->name }}</td>
                                                    <td class="py-2">{{ $customer->user->mobile }}</td>
                                                    <td>{{ $customer->user->email }}</td>
                                                </tr>
                                            @endforeach
                                        @endcan
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        $('.notification_table tr').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        // function check() {
        //     var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        //     for (var i = 0; i < checkboxes.length; i++) {
        //         checkboxes[i].checked = true;
        //     }
        // }
    </script>
@endpush
