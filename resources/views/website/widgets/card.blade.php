<article class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight">
        {{ $widget['content']['title'] ?? '' }}
    </h3>

    <p class="mt-2 leading-relaxed text-zinc-600">
        {{ $widget['content']['text'] ?? '' }}
    </p>
</article>