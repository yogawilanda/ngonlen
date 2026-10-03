<div
    x-data="studio({
        activePage: @js($activePage),
        activeSection: @js($activeSection),
        activeWidget: @js($activeWidget),
        activePanel: @js($activePanel),
    })"
    class="flex h-screen min-h-0 flex-col"
>
    @include('studio.components.top-nav')

    <div class="flex min-h-0 flex-1">

        {{-- Desktop sidebar --}}
        <aside class="hidden w-80 shrink-0 flex-col border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900 md:flex">
            <nav
                aria-label="Studio panels"
                class="grid grid-cols-4 border-b border-zinc-200 p-2 dark:border-zinc-800"
            >
                @foreach ([
                    'pages' => 'Pages',
                    'sections' => 'Sections',
                    'widgets' => 'Widgets',
                    'theme' => 'Theme',
                ] as $panel => $label)
                    <button
                        type="button"
                        @click="togglePanel('{{ $panel }}')"
                        :class="activePanel === '{{ $panel }}'
                            ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900'
                            : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'"
                        class="rounded-lg px-2 py-2 text-xs font-medium"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </nav>

            <div class="min-h-0 flex-1 overflow-y-auto">
                @include('studio.components.bottom-sheet')
            </div>
        </aside>

        {{-- Canvas --}}
        <div
            role="region"
            aria-label="Website canvas"
            class="relative min-w-0 flex-1 overflow-auto p-3 pb-20 sm:p-6 md:pb-6"
        >
            @include('studio.components.canvas')
        </div>
    </div>

    {{-- Mobile bottom sheet --}}
    <div class="md:hidden">
        @include('studio.components.bottom-sheet')
    </div>

    {{-- Mobile bottom navigation --}}
    @include('studio.components.bottom-nav')

    @include('studio.components.toast')
</div>
