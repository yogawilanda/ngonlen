{{-- resources/views/website/widgets/heading.blade.php --}}
@php
    $size = $widget['settings']['size'] ?? 'lg';
    $classes = match ($size) {
        'sm' => 'text-xl sm:text-2xl',
        'lg' => 'text-3xl sm:text-4xl',
        'xl' => 'text-4xl sm:text-6xl',
        default => 'text-2xl sm:text-3xl',
    };
@endphp

<h2 class="{{ $classes }} {{ $theme['typography']['heading'] ?? 'font-bold' }} tracking-tight">
    {{ $widget['content']['text'] ?? '' }}
</h2>
