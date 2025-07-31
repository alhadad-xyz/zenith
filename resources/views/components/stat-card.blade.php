@props(['title', 'value', 'label', 'href' => null, 'class' => ''])

@php
    $tag = $href ? 'a' : 'div';
    $linkAttributes = $href ? ['href' => $href] : [];
    $clickHandler = $href ? 'onclick="window.location.href=\'' . $href . '\'"' : '';
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => 'card stage-card ' . $class])->merge($linkAttributes) }} @if($href && $tag === 'div') {!! $clickHandler !!} @endif>
    <div class="stage-header">
        <h2 class="stage-title">{{ $title }}</h2>
        <span class="stage-count">{{ $value }}</span>
    </div>
    <div class="stage-content">
        <div class="stage-metric">{{ $value }}</div>
        <div class="stage-label">{{ $label }}</div>
        {{ $slot }}
    </div>
</{{ $tag }}>