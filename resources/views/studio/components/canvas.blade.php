{{-- resources/views/studio/components/canvas.blade.php --}}
<div inert aria-label="Non-interactive website preview" class="mx-auto min-h-full max-w-7xl overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800">
    @include('website.shell', [
        'website' => $website,
        'pageId' => $activePage,
    ])
</div>
