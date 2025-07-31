@props(['name', 'placeholder' => '', 'value' => '', 'rows' => 4])

<textarea 
    name="{{ $name }}" 
    class="form-textarea" 
    placeholder="{{ $placeholder }}" 
    rows="{{ $rows }}"
    {{ $attributes }}
>{{ old($name, $value) }}</textarea>