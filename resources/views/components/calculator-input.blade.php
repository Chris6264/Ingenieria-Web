<div class="row mb-3 align-items-center">
    <div class="col-6 fs-4 d-flex justify-content-end">{{ $label }}:</div>
    <div class="col-6">
        <input type="{{ $type }}" 
               class="form-control fs-3 w-75" 
               id="{{ $id }}"
               name="{{ $name }}"
               placeholder="{{ $placeholder }}"
               value="{{ $value }}"
               @if($readonly) readonly @endif
               @if($min) min="{{ $min }}" @endif>
    </div>
</div>