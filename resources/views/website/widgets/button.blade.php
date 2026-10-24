@php
$url = (string) ($widget['content']['url'] ?? '#');
$isSafeUrl = str_starts_with($url, '#')
|| (str_starts_with($url, '/') && ! str_starts_with($url, '//'))
|| str_starts_with($url, 'https://')
|| str_starts_with($url, 'http://')
|| str_starts_with($url, 'mailto:')
|| str_starts_with($url, 'tel:');
@endphp

@if ($isSafeUrl)
<a href="{{ $url }}"
    class="theme-primary inline-flex items-center justify-center rounded-lg px-5 py-3 text-sm font-semibold transition">
    {{ $widget['content']['label'] ?? 'Button' }}
</a>
@else
<span
    class="inline-flex items-center justify-center rounded-lg bg-zinc-200 px-5 py-3 text-sm font-semibold text-zinc-700">
    {{ $widget['content']['label'] ?? 'Button' }}
</span>
@endif
