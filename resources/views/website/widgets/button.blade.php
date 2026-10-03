@php
    $url = (string) ($widget['content']['url'] ?? '#');
    $isSafeUrl = str_starts_with($url, '#')
        || (str_starts_with($url, '/') && ! str_starts_with($url, '//'))
        || str_starts_with($url, 'https://')
        || str_starts_with($url, 'http://')
        || str_starts_with($url, 'mailto:')
        || str_starts_with($url, 'tel:');
    $primaryClass = match ($theme['colors']['primary'] ?? 'sky') {
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700',
        'violet' => 'bg-violet-600 hover:bg-violet-700',
        default => 'bg-sky-600 hover:bg-sky-700',
    };
@endphp

@if ($isSafeUrl)
    <a href="{{ $url }}" class="inline-flex items-center justify-center rounded-lg {{ $primaryClass }} px-5 py-3 text-sm font-semibold text-white transition">
        {{ $widget['content']['label'] ?? 'Button' }}
    </a>
@else
    <span class="inline-flex items-center justify-center rounded-lg bg-zinc-200 px-5 py-3 text-sm font-semibold text-zinc-700">
        {{ $widget['content']['label'] ?? 'Button' }}
    </span>
@endif