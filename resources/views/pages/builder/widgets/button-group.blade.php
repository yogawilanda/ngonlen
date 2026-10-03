<div class="mt-6 flex flex-wrap gap-2">
    @foreach ($widget['content']['buttons'] ?? [] as $button)
        <flux:button
            variant="{{ $button['variant'] ?? 'primary' }}"
            href="{{ $button['url'] ?? '#' }}"
        >
            {{ $button['label'] ?? 'Button' }}
        </flux:button>
    @endforeach
</div>
