@props(['type' => 'text', 'name', 'placeholder' => '', 'value' => '', 'required' => false])

<input 
    type="{{ $type }}" 
    name="{{ $name }}" 
    class="form-input" 
    placeholder="{{ $placeholder }}" 
    value="{{ old($name, $value) }}"
    @if($required) required @endif
    {{ $attributes }}
>