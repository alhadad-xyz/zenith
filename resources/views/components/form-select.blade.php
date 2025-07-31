@props(['name', 'options' => [], 'selected' => '', 'placeholder' => 'Select option'])

<select name="{{ $name }}" class="form-select" {{ $attributes }}>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    
    @foreach($options as $value => $label)
        <option value="{{ $value }}" @if(old($name, $selected) == $value) selected @endif>
            {{ $label }}
        </option>
    @endforeach
    
    {{ $slot }}
</select>