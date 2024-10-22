<div>
    <div class="basic-form">
        <form @role('visitor') action="#" @else @can($route) action="{{ route($route, $updateId) }}"@endcan @endrole method="POST" enctype="multipart/form-data"> @csrf
            @if($method)  @method('put') @endif
            {{ $slot }}

            @can($route)
            <div class="form-group text-right mt-3 mb-0">
                <button @role('visitor') type="button" @else type="submit" @endrole class="btn btn-primary mb-2 @role('visitor') visitorMessage @endrole">{{ __($type) }}</button>
            </div>
            @endcan
        </form>
    </div>
</div>
