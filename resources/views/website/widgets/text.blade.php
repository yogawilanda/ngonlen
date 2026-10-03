@php
    $style = $widget['settings']['style'] ?? 'body';
@endphp

<p @class([
    'max-w-2xl',
    'font-semibold uppercase tracking-wider text-sky-700' => $style === 'eyebrow',
    'text-base leading-relaxed text-zinc-600 sm:text-lg' => $style !== 'eyebrow',
])>
    {{ $widget['content']['text'] ?? '' }}
</p>