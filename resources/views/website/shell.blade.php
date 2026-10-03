@php
    $page = collect($website['pages'])->firstWhere('id', $pageId);
    $theme = $website['theme'];
@endphp

<div class="min-h-full bg-white text-zinc-900 {{ $theme['typography']['font'] === 'serif' ? 'font-serif' : 'font-sans' }}">
    <header class="border-b border-zinc-200">
        <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-6 px-5 sm:px-8">
            <a href="/" class="font-semibold tracking-tight">
                {{ $website['name'] }}
            </a>

            <nav aria-label="Website navigation" class="flex flex-wrap items-center justify-end gap-4 text-sm">
                @foreach ($website['navigation']['items'] ?? [] as $item)
                    @php
                        $navigationPage = collect($website['pages'])->firstWhere('id', $item['page'] ?? null);
                        $navigationPath = $navigationPage['path'] ?? '#';
                    @endphp

                    @if ($navigationPage && (str_starts_with($navigationPath, '/') && ! str_starts_with($navigationPath, '//') || str_starts_with($navigationPath, '#')))
                        <a href="{{ $navigationPath }}" class="transition hover:text-sky-700">
                            {{ $item['label'] ?? $navigationPage['name'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
    </header>

    @if ($page)
        @include('website.page', [
            'page' => $page,
            'theme' => $theme,
        ])
    @else
        <main class="mx-auto max-w-7xl px-5 py-16 text-sm text-zinc-600 sm:px-8">
            The selected page is not part of this website model.
        </main>
    @endif
</div>