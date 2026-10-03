<div class="max-w-3xl divide-y divide-zinc-200">
    @foreach ($widget['content']['items'] ?? [] as $item)
        <details class="group py-4">
            <summary class="cursor-pointer list-none font-semibold text-zinc-900">
                {{ $item['question'] ?? 'Question' }}
            </summary>
            <p class="pt-3 leading-relaxed text-zinc-600">
                {{ $item['answer'] ?? '' }}
            </p>
        </details>
    @endforeach
</div>