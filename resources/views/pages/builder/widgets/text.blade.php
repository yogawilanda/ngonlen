@php
    $style = $widget['settings']['style'] ?? 'body';
@endphp

<flux:text
    @class([
        'mt-4 max-w-2xl',
        'font-semibold uppercase tracking-wider text-sky-600' => $style === 'eyebrow',
        'leading-relaxed' => $style === 'body',
    ])
>
    {{ $widget['content']['text'] ?? '' }}
</flux:text>
