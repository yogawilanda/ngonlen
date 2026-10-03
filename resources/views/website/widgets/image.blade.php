@php
    $src = (string) ($widget['content']['src'] ?? '');
    $isSafeImageUrl = str_starts_with($src, 'https://')
        || str_starts_with($src, 'http://')
        || (str_starts_with($src, '/') && ! str_starts_with($src, '//'));
@endphp

@if ($isSafeImageUrl)
    <img src="{{ $src }}" alt="{{ $widget['content']['alt'] ?? '' }}" class="h-auto max-h-[32rem] w-full rounded-xl object-cover">
@else
    <div class="flex min-h-48 items-center justify-center rounded-xl bg-zinc-100 text-sm text-zinc-500" role="img" aria-label="{{ $widget['content']['alt'] ?? 'Image placeholder' }}">
        Image placeholder
    </div>
@endif