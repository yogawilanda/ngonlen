@php
    $primaryClass = match ($theme['colors']['primary'] ?? 'sky') {
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700',
        'violet' => 'bg-violet-600 hover:bg-violet-700',
        default => 'bg-sky-600 hover:bg-sky-700',
    };
@endphp

<div class="flex flex-wrap gap-3">
    @foreach ($widget['content']['buttons'] ?? [] as $button)
        @php
            $url = (string) ($button['url'] ?? '#');
            $isSafeUrl = str_starts_with($url, '#')
                || (str_starts_with($url, '/') && ! str_starts_with($url, '//'))
                || str_starts_with($url, 'https://')
                || str_starts_with($url, 'http://')
                || str_starts_with($url, 'mailto:')
                || str_starts_with($url, 'tel:');
            $variantClass = ($button['variant'] ?? 'primary') === 'primary'
                ? "{$primaryClass} text-white"
                : 'border border-zinc-300 bg-white text-zinc-800 hover:bg-zinc-50';
        @endphp

        @if ($isSafeUrl)
            <a href="{{ $url }}" class="inline-flex items-center justify-center rounded-lg px-5 py-3 text-sm font-semibold transition {{ $variantClass }}">
                {{ $button['label'] ?? 'Button' }}
            </a>
        @else
            <span class="inline-flex items-center justify-center rounded-lg bg-zinc-200 px-5 py-3 text-sm font-semibold text-zinc-700">
                {{ $button['label'] ?? 'Button' }}
            </span>
        @endif
    @endforeach
</div>