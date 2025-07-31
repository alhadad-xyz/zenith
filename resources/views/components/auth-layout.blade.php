<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Zenith - Authentication' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <x-base-styles />
    <x-form-styles />
    
    {{ $styles ?? '' }}
</head>
<body>
    {{ $slot }}

    {{ $scripts ?? '' }}
</body>
</html>