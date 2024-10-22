<div>
    <div class="form-group">
        <textarea name="{{ $name }}" class="form-control @error($name) is-invalid @enderror" rows="4" id="comment" placeholder="{{$placeholder}}">{{ $value ? $value : old('description')  }}</textarea>
        @error($name)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>