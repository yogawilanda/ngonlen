{{-- resources/views/studio/components/bottom-sheet.blade.php --}}

<section x-show="activePanel !== ''" x-cloak x-transition:enter="transform transition ease-out duration-100"
    x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
    x-transition:leave="transform transition ease-in duration-150" x-transition:leave-start="translate-y-0"
    x-transition:leave-end="translate-y-full" :class="activePanel !== ''
        ? 'fixed inset-x-0 bottom-[5%] z-40 max-h-[65vh] overflow-y-auto rounded-t-2xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-700 dark:bg-zinc-900 md:static md:max-h-none md:flex-1 md:rounded-none md:border-0 md:shadow-none'
        : 'hidden'" aria-label="Studio editor panel">
    {{-- Pages --}}
    <div x-show="activePanel === 'pages'" x-cloak>
        <div class="p-4">

            {{-- Header --}}
            <div class="mb-4 flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Pages
                    </h2>

                    <p class="mt-0.5 text-xs text-zinc-500">
                        {{ count($website['pages']) }}
                        {{ count($website['pages']) === 1 ? 'page' : 'pages' }}
                    </p>
                </div>

                <button type="button" @click="$dispatch('open-add-page')"
                    class="inline-flex shrink-0 items-center gap-1.5 rounded-lg bg-zinc-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                    <span class="text-sm leading-none">+</span>
                    Add page
                </button>
            </div>

            {{-- Page list --}}
            @if (count($website['pages']) > 0)
            <div class="space-y-2">

                @foreach ($website['pages'] as $page)
                <div wire:key="page-{{ $page['id'] }}" x-data="{ menuOpen: false }" class="relative">
                    <div class="rounded-xl border transition"
                        :class="activePage === '{{ $page['id'] }}'
                                ? 'border-sky-300 bg-sky-50 dark:border-sky-800 dark:bg-sky-950/50'
                                : 'border-zinc-200 bg-white hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700 dark:hover:bg-zinc-800'">

                        {{-- Page selector --}}
                        <button type="button" @click="selectPage('{{ $page['id'] }}')" class="w-full p-3 text-left">
                            <div class="flex items-start gap-3">

                                {{-- Icon --}}
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border bg-white dark:bg-zinc-900"
                                    :class="activePage === '{{ $page['id'] }}'
                                            ? 'border-sky-200 text-sky-600 dark:border-sky-800 dark:text-sky-400'
                                            : 'border-zinc-200 text-zinc-500 dark:border-zinc-700 dark:text-zinc-400'">
                                    @if ($page['path'] === '/')
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z" />
                                    </svg>
                                    @else
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5Z" />
                                        <path stroke-linecap="round" d="M8 7h8M8 11h8M8 15h5" />
                                    </svg>
                                    @endif
                                </div>

                                {{-- Page information --}}
                                <div class="min-w-0 flex-1">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <span class="truncate text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $page['name'] }}
                                        </span>

                                        @if ($page['path'] === '/')
                                        <span
                                            class="shrink-0 rounded-md bg-zinc-100 px-1.5 py-0.5 text-[10px] font-medium text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                            Home
                                        </span>
                                        @endif
                                    </div>

                                    <div class="mt-1 flex min-w-0 items-center gap-1.5 text-xs text-zinc-500">
                                        <span class="truncate">
                                            {{ $page['path'] }}
                                        </span>

                                        <span aria-hidden="true">
                                            ·
                                        </span>

                                        <span class="shrink-0">
                                            {{ count($page['sections']) }}
                                            {{ count($page['sections']) === 1 ? 'section' : 'sections' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Active indicator --}}
                                <div x-show="activePage === '{{ $page['id'] }}'" x-cloak
                                    class="mt-1 h-2 w-2 shrink-0 rounded-full bg-sky-500" aria-hidden="true"></div>
                            </div>
                        </button>

                        {{-- Page actions --}}
                        <div class="absolute right-2 top-2">

                            <button type="button" @click.stop="menuOpen = !menuOpen" :aria-expanded="menuOpen"
                                aria-label="Page actions"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="5" cy="12" r="1" fill="currentColor" />
                                    <circle cx="12" cy="12" r="1" fill="currentColor" />
                                    <circle cx="19" cy="12" r="1" fill="currentColor" />
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="menuOpen" x-cloak @click.outside="menuOpen = false" x-transition
                                class="absolute right-0 top-9 z-50 w-40 overflow-hidden rounded-xl border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                                {{-- Rename --}}
                                <button type="button" @click="
                                            menuOpen = false;
                                            $dispatch('open-rename-page', {
                                                id: '{{ $page['id'] }}',
                                                name: @js($page['name']),
                                                path: @js($page['path'])
                                            });
                                        "
                                    class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-400" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5Z" />
                                    </svg>

                                    Rename
                                </button>

                                {{-- Duplicate --}}
                                <button type="button" wire:click="duplicatePage('{{ $page['id'] }}')"
                                    @click="menuOpen = false"
                                    class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-400" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <rect x="8" y="8" width="12" height="12" rx="2" />
                                        <path stroke-linecap="round"
                                            d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2" />
                                    </svg>

                                    Duplicate
                                </button>

                                <div class="my-1 border-t border-zinc-100 dark:border-zinc-800"></div>

                                {{-- Delete --}}
                                @if ($page['path'] !== '/')
                                <button type="button" @click="
                                                menuOpen = false;
                                                $dispatch('confirm-delete-page', {
                                                    id: '{{ $page['id'] }}',
                                                    name: @js($page['name'])
                                                });
                                            "
                                    class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4h8v2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 6-1 15H6L5 6" />
                                    </svg>

                                    Delete
                                </button>
                                @else
                                <div class="flex items-center gap-2 px-3 py-2 text-xs text-zinc-400 dark:text-zinc-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 17h.01" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>

                                    Home cannot be deleted
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @else
            {{-- Empty state --}}
            <div class="rounded-xl border border-dashed border-zinc-300 p-6 text-center dark:border-zinc-700">
                <div
                    class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-100 text-zinc-500 dark:bg-zinc-800">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5Z" />
                        <path stroke-linecap="round" d="M8 7h8M8 11h8" />
                    </svg>
                </div>

                <p class="mt-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    No pages yet
                </p>

                <p class="mt-1 text-xs leading-relaxed text-zinc-500">
                    Create a page to start building your website.
                </p>

                <button type="button" @click="$dispatch('open-add-page')"
                    class="mt-4 rounded-lg bg-zinc-900 px-3 py-2 text-xs font-semibold text-white dark:bg-white dark:text-zinc-900">
                    Add page
                </button>
            </div>
            @endif

        </div>
    </div>


    {{-- Sections --}}
    <div x-show="activePanel === 'sections'">
        <div class="space-y-3 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold">
                    Sections
                </h2>

                <button type="button" wire:click="addSection"
                    class="rounded-lg bg-zinc-900 px-3 py-2 text-xs font-semibold text-white dark:bg-white dark:text-zinc-900">
                    Add section
                </button>
            </div>

            @if ($currentPage)
            <ul class="space-y-1">
                @foreach ($currentPage['sections'] as $index => $section)
                <li wire:key="section-{{ $section['id'] }}">
                    <button type="button" @click="selectSection('{{ $section['id'] }}')" :class="activeSection === '{{ $section['id'] }}'
                                    ? 'bg-sky-50 font-medium text-sky-800 dark:bg-sky-950 dark:text-sky-200'
                                    : 'hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm">
                        <span>
                            {{ $section['name'] ?? 'Section ' . ($index + 1) }}
                        </span>

                        <span class="text-xs text-zinc-500">
                            {{ count($section['widgets']) }}
                        </span>
                    </button>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-sm text-zinc-500">
                Select a page to manage its sections.
            </p>
            @endif
        </div>
    </div>


    {{-- Widgets --}}
    <div x-show="activePanel === 'widgets'">
        <div class="space-y-5 p-4">
            <div>
                <h2 class="text-sm font-semibold">
                    Widgets
                </h2>

                @if ($currentSection)
                <p class="mt-1 text-xs text-zinc-500">
                    In selected section
                </p>
                @else
                <p class="mt-1 text-xs text-zinc-500">
                    Select a section to add a widget.
                </p>
                @endif
            </div>

            @if ($currentSection)
            <div class="grid grid-cols-2 gap-2">
                @foreach ([
                'heading',
                'text',
                'button',
                'button-group',
                'image',
                'card',
                'table',
                'form',
                'gallery',
                'faq',
                ] as $type)
                <button type="button" wire:click="addWidget('{{ $type }}')"
                    class="rounded-lg border border-zinc-200 px-3 py-2 text-left text-xs font-medium capitalize hover:border-sky-400 hover:bg-sky-50 dark:border-zinc-700 dark:hover:bg-sky-950">
                    {{ $type }}
                </button>
                @endforeach
            </div>

            <div class="space-y-1">
                <h3 class="mb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                    Section widgets
                </h3>

                @foreach ($currentSection['widgets'] as $index => $widget)
                <button type="button" wire:key="widget-{{ $widget['id'] }}" @click="selectWidget('{{ $widget['id'] }}')"
                    :class="activeWidget === '{{ $widget['id'] }}'
                                ? 'bg-sky-50 font-medium text-sky-800 dark:bg-sky-950 dark:text-sky-200'
                                : 'hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm">
                    <span class="capitalize">
                        {{ $widget['type'] }}
                    </span>

                    <span class="text-xs text-zinc-500">
                        {{ $index + 1 }}
                    </span>
                </button>
                @endforeach
            </div>

            @if (
            $currentWidget &&
            $currentWidgetIndex !== null &&
            $currentPageIndex !== null &&
            $currentSectionIndex !== null
            )
            <div class="space-y-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                <h3 class="text-sm font-semibold">
                    Edit {{ $currentWidget['type'] }}
                </h3>

                @foreach ($currentWidgetFields as $field)
                <label class="block space-y-1 text-xs font-medium text-zinc-600 dark:text-zinc-300">
                    <span>
                        {{ $field['label'] }}
                    </span>

                    <input type="text"
                        wire:model.live="website.pages.{{ $currentPageIndex }}.sections.{{ $currentSectionIndex }}.widgets.{{ $currentWidgetIndex }}.content.{{ $field['path'] }}"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </label>
                @endforeach
            </div>
            @endif
            @endif
        </div>
    </div>


    {{-- Theme --}}
    <div x-show="activePanel === 'theme'">
        <div class="space-y-3 p-4">
            <h2 class="text-sm font-semibold">
                Theme
            </h2>

            <p class="text-xs text-zinc-500">
                Theme selection updates the Website Model.
            </p>

            <ul class="space-y-1">
                @foreach ($availableThemes as $theme)
                <li wire:key="theme-{{ \Illuminate\Support\Str::slug($theme) }}">
                    <button type="button" wire:click="selectTheme('{{ $theme }}')"
                        class="w-full rounded-lg px-3 py-2 text-left text-sm" :class="$wire.website.theme.name === @js($theme)
                                ? 'bg-sky-50 font-medium text-sky-800 dark:bg-sky-950 dark:text-sky-200'
                                : 'hover:bg-zinc-100 dark:hover:bg-zinc-800'">
                        {{ $theme }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Add Page Modal --}}
    <div x-data="{
        open: false,
        name: '',
        path: '',

        submit() {
            if (!this.name.trim()) {
                return
            }

            this.$wire.addPage(this.name, this.path)
            this.open = false
            this.name = ''
            this.path = ''
        }
    }" @open-add-page.window="
        open = true;
        name = '';
        path = '';
        $nextTick(() => $refs.name?.focus());
    " x-show="open" x-cloak
        class="fixed inset-0 z-[70] flex items-end justify-center bg-zinc-950/40 p-0 sm:items-center sm:p-4">
        <div @click.outside="open = false" x-transition
            class="w-full max-w-md rounded-t-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900 sm:rounded-2xl">
            <div class="mb-5 flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Add page
                    </h3>

                    <p class="mt-1 text-xs text-zinc-500">
                        Create a new page for your website.
                    </p>
                </div>

                <button type="button" @click="open = false"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-zinc-400 hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                    aria-label="Close">
                    ×
                </button>
            </div>

            <form @submit.prevent="submit" class="space-y-4">

                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-700 dark:text-zinc-300">
                        Page name
                    </label>

                    <input x-ref="name" x-model="name" type="text" placeholder="About"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-700 dark:text-zinc-300">
                        URL path
                    </label>

                    <div
                        class="flex items-center overflow-hidden rounded-lg border border-zinc-300 bg-white focus-within:border-sky-500 dark:border-zinc-700 dark:bg-zinc-950">
                        <span class="px-3 text-sm text-zinc-400">
                            /
                        </span>

                        <input x-model="path" type="text" placeholder="about"
                            class="min-w-0 flex-1 border-0 bg-transparent px-0 py-2.5 text-sm outline-none focus:ring-0 dark:text-zinc-100">
                    </div>

                    <p class="mt-1.5 text-[11px] text-zinc-500">
                        Leave empty to generate the path from the page name.
                    </p>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="button" @click="open = false"
                        class="flex-1 rounded-lg border border-zinc-300 px-3 py-2.5 text-xs font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        Cancel
                    </button>

                    <button type="submit" :disabled="!name.trim()"
                        class="flex-1 rounded-lg bg-zinc-900 px-3 py-2.5 text-xs font-semibold text-white transition disabled:cursor-not-allowed disabled:opacity-40 dark:bg-white dark:text-zinc-900">
                        Create page
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Delete Page Confirmation --}}
    <div x-data="{
        open: false,
        id: null,
        name: '',

        confirm() {
            this.$wire.deletePage(this.id)
            this.open = false
        }
    }" @confirm-delete-page.window="
        id = $event.detail.id;
        name = $event.detail.name;
        open = true;
    " x-show="open" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-zinc-950/40 p-4">
        <div @click.outside="open = false" x-transition
            class="w-full max-w-sm rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17h.01" />
                    <circle cx="12" cy="12" r="9" />
                </svg>
            </div>

            <h3 class="mt-4 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                Delete page?
            </h3>

            <p class="mt-1 text-xs leading-relaxed text-zinc-500">
                This will delete
                <span class="font-medium text-zinc-700 dark:text-zinc-300" x-text="name"></span>
                and its sections. This action cannot be undone.
            </p>

            <div class="mt-5 flex gap-2">
                <button type="button" @click="open = false"
                    class="flex-1 rounded-lg border border-zinc-300 px-3 py-2.5 text-xs font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    Cancel
                </button>

                <button type="button" @click="confirm()"
                    class="flex-1 rounded-lg bg-red-600 px-3 py-2.5 text-xs font-semibold text-white hover:bg-red-700">
                    Delete page
                </button>
            </div>
        </div>
    </div>
</section>
