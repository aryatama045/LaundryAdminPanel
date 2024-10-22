<div>
    <div class="form-group">
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" class="form-control input-default @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}" value="{{ $value ? $value : old($name) }}">
        @error($name)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
