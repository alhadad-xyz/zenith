@props(['label', 'error' => null, 'required' => false])

<div class="form-group">
    @if($label)
        <label class="form-label">
            {{ $label }}
            @if($required)
                <span style="color: #ff6b6b;">*</span>
            @endif
        </label>
    @endif
    
    {{ $slot }}
    
    @if($error)
        <div class="form-error">{{ $error }}</div>
    @endif
</div>