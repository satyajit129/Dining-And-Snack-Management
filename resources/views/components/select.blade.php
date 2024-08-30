<div class="form-group col-md-12 mb-4">
    <label>{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $id }}" class="{{ $class ?? 'form-select' }}">
        {{ $slot }}
    </select>
</div>