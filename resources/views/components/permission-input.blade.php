<div class="row">
    <div class="col-6">
        {{ __($title) }}:
    </div>
    <div class="col-6">
        @if (in_array($permission, $permissions))
            <label for="{{ $name }}_yes" class="mx-2">
                <input type="radio" id="{{ $name }}_yes" checked name="{{ $name }}" value="{{ $permission }}"> {{ __('Yes') }}
            </label>
            <label for="{{ $name }}_no">
                <input type="radio" id="{{ $name }}_no" name="{{ $name }}" value=""> {{ __('No') }}
            </label>
        @else
            <label for="{{ $name }}_yes" class="mx-2">
                <input type="radio" id="{{ $name }}_yes" name="{{ $name }}" value="{{ $permission }}"> {{ __('Yes') }}
            </label>
            <label for="{{ $name }}_no">
                <input type="radio" id="{{ $name }}_no" checked name="{{ $name }}" value=""> {{ __('No') }}
            </label>
        @endif
    </div>
</div>
