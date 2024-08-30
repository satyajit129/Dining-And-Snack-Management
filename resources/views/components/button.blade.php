<div class="col-md-12">
    <button id="{{ $id ?? '' }}" 
            type="{{ $type ?? 'button' }}" 
            class="btn {{ $class ?? 'btn-primary' }} {{ $additionalClass ?? '' }}">
        <span id="{{ $id }}Text">{{ $slot }}</span>
        
    </button>
</div>
