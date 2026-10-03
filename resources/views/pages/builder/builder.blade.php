{{-- resources/views/pages/builder/builder.blade.php --}}
@php
    $currentPage = collect($website['pages'])
        ->firstWhere('name', $activePage);
@endphp

<flux:card class="overflow-hidden bg-white p-0 dark:bg-zinc-900">

    {{-- Website Navbar --}}
    <div
        class="flex h-14 items-center justify-between border-b border-zinc-200 px-5 dark:border-zinc-800 sm:h-16 sm:px-8"
    >
        <flux:heading size="sm">
            {{ strtoupper($website['name']) }}
        </flux:heading>

        <nav class="hidden items-center gap-6 md:flex">
            @foreach ($website['pages'] as $page)
                <button
                    type="button"
                    wire:click="selectPage('{{ $page['name'] }}')"
                    class="text-sm transition hover:text-sky-600"
                >
                    {{ $page['name'] }}
                </button>
            @endforeach
        </nav>

        <div class="md:hidden">
            <flux:button
                variant="ghost"
                icon="bars-2"
                size="sm"
            />
        </div>
    </div>

    {{-- Dynamic Page --}}
    @foreach ($currentPage['sections'] ?? [] as $section)
        @include('pages.builder.section', [
            'section' => $section,
            'theme' => $website['theme'],
        ])
    @endforeach

    {{-- Bottom Navbar --}}

</flux:card>
