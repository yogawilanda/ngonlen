{{-- resources/views/studio/components/top-nav.blade.php --}}
<header
    class="z-10 flex min-h-16 items-center justify-between gap-4 border-b border-zinc-200 bg-white px-4 dark:border-zinc-800 dark:bg-zinc-900 sm:px-6">
    <div class="min-w-0">
        <div class="flex items-center gap-2">
            <span
                class="rounded-md bg-sky-100 px-2 py-1 text-xs font-semibold text-sky-800 dark:bg-sky-950 dark:text-sky-200">
                STUDIO
            </span>

            <label class="sr-only" for="website-name">
                Website name
            </label>

            <input id="website-name" type="text" wire:model.live="website.name"
                class="w-36 truncate border-0 bg-transparent p-0 text-sm font-semibold focus:ring-0 sm:w-56"
                aria-label="Website name">
        </div>

        <label class="sr-only" for="website-domain">
            Website domain
        </label>

        <input id="website-domain" type="text" wire:model.live="website.domain"
            class="mt-1 w-48 border-0 bg-transparent p-0 text-xs text-zinc-500 focus:ring-0"
            aria-label="Website domain">
    </div>

    <div class="flex shrink-0 items-center gap-2">
        <span class="hidden text-xs text-zinc-500 sm:inline">
            Model preview
        </span>

        <span
            class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
            {{ $website['theme']['name'] }}
        </span>
    </div>
</header>
