<div class="form-group col-md-12 mb-4">
    @if(isset($label))
        <label for="{{ $id }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ $value ?? '' }}"
        class="{{ $class ?? 'form-control input-lg' }}" placeholder="{{ $placeholder ?? '' }}" />
</div>
