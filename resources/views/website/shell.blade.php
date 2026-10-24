@php
    $page = collect($website['pages'] ?? [])->firstWhere('id', $pageId);
    $theme = $website['theme'] ?? [];
@endphp

@include('website.theme-styles', ['theme' => $theme])

<div
    class="website-theme min-h-full {{ ($theme['typography']['font'] ?? 'sans') === 'serif' ? 'font-serif' : 'font-sans' }}"
>
    <header class="theme-border border-b">
        <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-6 px-5 sm:px-8">
            <a href="/" class="font-semibold tracking-tight">
                {{ $website['name'] ?? 'Website' }}
            </a>

            <nav aria-label="Website navigation" class="flex flex-wrap items-center justify-end gap-4 text-sm">
                @foreach ($website['pages'] ?? [] as $navigationPage)
                    @php
                        $navigationPath = $navigationPage['path'] ?? '/';
                    @endphp

                    <a
                        href="{{ $navigationPath }}"
                        class="theme-link transition"
                    >
                        {{ $navigationPage['name'] ?? 'Page' }}
                    </a>
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
        <main class="mx-auto max-w-7xl px-5 py-16 text-sm theme-muted sm:px-8">
            The selected page is not part of this website model.
        </main>
    @endif
</div>
