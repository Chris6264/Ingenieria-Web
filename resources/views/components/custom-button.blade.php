<div class="col-6 d-flex {{ $align === 'right' ? 'justify-content-end' : 'justify-content-start' }}">
    <button type="submit" 
            class="btn btn-dark btn-lg w-75 py-3" 
            name="option" 
            value="{{ $value }}">
        {{ $slot }}
    </button>
</div>
