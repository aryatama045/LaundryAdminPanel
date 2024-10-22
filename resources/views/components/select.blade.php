<div>
    <div class="form-group">
        <select {{ $multi ? 'multiple' : '' }} name="{{ $name }}" class="form-control select2 @error($name) is-invalid @enderror" style="width: 100%">
            {{ $slot }}
        </select>
        @error($name)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
