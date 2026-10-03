<div
    class="flex min-h-[calc(100vh-4rem)] flex-col"
    x-data="{
        toast: '',
        visible: false,
        timer: null,

        showToast(message) {
            this.toast = message
            this.visible = true

            clearTimeout(this.timer)

            this.timer = setTimeout(() => {
                this.visible = false
            }, 2200)
        }
    }"
    x-on:builder-toast.window="showToast($event.detail.message)"
>
    {{-- Topbar --}}
    <header class="flex h-16 shrink-0 items-center gap-3 border-b border-zinc-200 bg-white px-4 dark:border-zinc-800 dark:bg-zinc-900">
        <flux:button
            wire:click="back"
            variant="ghost"
            icon="arrow-left"
        >
            Kembali
        </flux:button>

        <flux:separator vertical />

        <div class="min-w-0 flex-1">
            <flux:heading size="sm" class="truncate">
                {{ $websiteName }}
            </flux:heading>

            <flux:text size="sm" class="truncate">
                {{ $websiteDomain }}
            </flux:text>
        </div>

        <div class="flex items-center gap-2">
            <flux:button
                wire:click="preview"
                variant="ghost"
            >
                Preview
            </flux:button>

            <flux:button
                wire:click="save"
                variant="ghost"
            >
                Simpan
            </flux:button>

            <flux:button
                wire:click="publish"
                variant="primary"
            >
                Publish
            </flux:button>
        </div>
    </header>

    {{-- Builder --}}
    <div class="flex min-h-0 flex-1">
        {{-- Builder panel --}}
        <aside class="w-72 shrink-0 overflow-y-auto border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            {{-- Pages --}}
            <div class="space-y-3 border-b border-zinc-200 p-4 dark:border-zinc-800">
                <flux:heading size="sm">
                    Pages
                </flux:heading>

                <div class="space-y-2">
                    @foreach ($pages as $page)
                        <button
                            type="button"
                            wire:click="selectPage('{{ $page['name'] }}')"
                            @class([
                                'flex w-full items-center justify-between rounded-lg border px-3 py-2.5 text-left transition',
                                'border-sky-500 bg-sky-50 dark:bg-sky-950/30' => $activePage === $page['name'],
                                'border-zinc-200 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800' => $activePage !== $page['name'],
                            ])
                        >
                            <span class="text-sm font-medium">
                                {{ $page['name'] }}
                            </span>

                            <span class="text-xs text-zinc-500">
                                {{ $page['path'] }}
                            </span>
                        </button>
                    @endforeach
                </div>

                <flux:button
                    wire:click="addPage"
                    variant="ghost"
                    class="w-full"
                >
                    + Tambah page
                </flux:button>
            </div>

            {{-- Sections --}}
            <div class="space-y-3 border-b border-zinc-200 p-4 dark:border-zinc-800">
                <flux:heading size="sm">
                    Sections
                </flux:heading>

                <div class="space-y-2">
                    @foreach ($sections as $section)
                        <button
                            type="button"
                            wire:click="selectSection('{{ $section }}')"
                            @class([
                                'flex w-full items-center justify-between rounded-lg border px-3 py-2.5 text-left transition',
                                'border-sky-500 bg-sky-50 dark:bg-sky-950/30' => $activeSection === $section,
                                'border-zinc-200 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800' => $activeSection !== $section,
                            ])
                        >
                            <span class="text-sm font-medium">
                                {{ $section }}
                            </span>

                            <span class="text-xs text-zinc-500">
                                ⋮⋮
                            </span>
                        </button>
                    @endforeach
                </div>

                <flux:button
                    wire:click="addSection"
                    variant="ghost"
                    class="w-full"
                >
                    + Tambah section
                </flux:button>
            </div>

            {{-- Theme --}}
            <div class="space-y-3 p-4">
                <flux:heading size="sm">
                    Theme
                </flux:heading>

                <div class="space-y-2">
                    @foreach ($themes as $theme)
                        <button
                            type="button"
                            wire:click="selectTheme('{{ $theme }}')"
                            @class([
                                'w-full rounded-lg border p-3 text-left transition',
                                'border-sky-500 bg-sky-50 dark:bg-sky-950/30' => $activeTheme === $theme,
                                'border-zinc-200 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800' => $activeTheme !== $theme,
                            ])
                        >
                            <div class="mb-2 h-12 rounded border border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800"></div>

                            <flux:text class="font-medium">
                                {{ $theme }}
                            </flux:text>

                            @if ($activeTheme === $theme)
                                <flux:text size="sm">
                                    Aktif
                                </flux:text>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- Canvas --}}
        <main class="min-w-0 flex-1 overflow-auto bg-zinc-100 p-6 dark:bg-zinc-950">
            <div class="mx-auto max-w-6xl">
                <flux:card class="overflow-hidden bg-white p-0 dark:bg-zinc-900">
                    {{-- Website navbar --}}
                    <div class="flex h-16 items-center justify-between border-b border-zinc-200 px-8 dark:border-zinc-800">
                        <flux:heading size="sm">
                            {{ strtoupper($websiteName) }}
                        </flux:heading>

                        <div class="hidden items-center gap-6 md:flex">
                            <flux:text size="sm">Home</flux:text>
                            <flux:text size="sm">About</flux:text>
                            <flux:text size="sm">Contact</flux:text>
                        </div>
                    </div>

                    {{-- Hero --}}
                    <section class="border-b border-zinc-200 bg-zinc-50 px-8 py-20 dark:border-zinc-800 dark:bg-zinc-950">
                        <flux:text class="font-semibold uppercase tracking-wider text-sky-600">
                            Digital Studio
                        </flux:text>

                        <flux:heading size="xl" class="mt-4 max-w-2xl">
                            We build simple things that work.
                        </flux:heading>

                        <flux:text class="mt-4 max-w-2xl">
                            A clean starting point for a small business website.
                            Everything here will eventually be editable through Ngonlen.
                        </flux:text>

                        <div class="mt-6 flex gap-2">
                            <flux:button variant="primary">
                                Get started
                            </flux:button>

                            <flux:button variant="ghost">
                                Learn more
                            </flux:button>
                        </div>
                    </section>

                    {{-- Sections preview --}}
                    <section class="grid gap-4 p-8 md:grid-cols-3">
                        <flux:card>
                            <flux:heading size="sm">
                                Web Design
                            </flux:heading>

                            <flux:text class="mt-2">
                                Simple, responsive websites built around what your business actually needs.
                            </flux:text>
                        </flux:card>

                        <flux:card>
                            <flux:heading size="sm">
                                Development
                            </flux:heading>

                            <flux:text class="mt-2">
                                Fast and maintainable web experiences using a reusable production system.
                            </flux:text>
                        </flux:card>

                        <flux:card>
                            <flux:heading size="sm">
                                Support
                            </flux:heading>

                            <flux:text class="mt-2">
                                Keep your website updated without rebuilding everything from zero.
                            </flux:text>
                        </flux:card>
                    </section>
                </flux:card>

                <div class="mt-3 text-center">
                    <flux:text size="sm">
                        Page: {{ $activePage }}
                        · Section: {{ $activeSection }}
                        · Theme: {{ $activeTheme }}
                    </flux:text>
                </div>
            </div>
        </main>
    </div>

    {{-- Toast --}}
    <div
        x-cloak
        x-show="visible"
        x-transition
        class="fixed bottom-6 right-6 z-50"
    >
        <flux:card class="border-zinc-800 bg-zinc-900 px-4 py-3 text-white">
            <flux:text class="text-white" x-text="toast"></flux:text>
        </flux:card>
    </div>
</div>
