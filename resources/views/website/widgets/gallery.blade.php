<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($widget['content']['images'] ?? [] as $image)
        @php
            $src = is_array($image) ? (string) ($image['src'] ?? '') : (string) $image;
            $alt = is_array($image) ? (string) ($image['alt'] ?? '') : '';
            $isSafeImageUrl = str_starts_with($src, 'https://')
                || str_starts_with($src, 'http://')
                || (str_starts_with($src, '/') && ! str_starts_with($src, '//'));
        @endphp

        @if ($isSafeImageUrl)
            <img src="{{ $src }}" alt="{{ $alt }}" class="aspect-[4/3] w-full rounded-xl object-cover">
        @else
            <div class="flex aspect-[4/3] items-center justify-center rounded-xl bg-zinc-100 text-sm text-zinc-500" role="img" aria-label="{{ $alt ?: 'Gallery image placeholder' }}">
                Image placeholder
            </div>
        @endif
    @empty
        <p class="text-sm text-zinc-500">No gallery images yet.</p>
    @endforelse
</div>