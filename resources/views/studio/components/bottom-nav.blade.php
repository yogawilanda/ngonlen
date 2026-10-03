{{-- resources/views/studio/components/bottom-nav.blade.php --}}

<nav
    aria-label="Studio panels"
    class="fixed inset-x-0 bottom-0 z-50 grid grid-cols-4 border-t border-zinc-200 bg-white/95 p-2 backdrop-blur dark:border-zinc-800 dark:bg-zinc-900/95 md:hidden"
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
            class="rounded-lg px-2 py-2 text-xs font-medium transition"
        >
            {{ $label }}
        </button>
    @endforeach
</nav>
