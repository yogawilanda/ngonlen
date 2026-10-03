<form class="max-w-xl space-y-5" aria-label="Website form preview">
    @foreach ($widget['content']['fields'] ?? [] as $field)
        <div class="space-y-2">
            <label for="{{ $widget['id'] }}-{{ $field['name'] ?? $loop->index }}" class="block text-sm font-medium text-zinc-800">
                {{ $field['label'] ?? 'Field' }}
            </label>

            @if (($field['type'] ?? 'text') === 'textarea')
                <textarea id="{{ $widget['id'] }}-{{ $field['name'] ?? $loop->index }}" rows="4" @required($field['required'] ?? false) class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm"></textarea>
            @else
                <input
                    id="{{ $widget['id'] }}-{{ $field['name'] ?? $loop->index }}"
                    type="{{ in_array($field['type'] ?? 'text', ['text', 'email', 'tel', 'number'], true) ? $field['type'] : 'text' }}"
                    @required($field['required'] ?? false)
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm"
                >
            @endif
        </div>
    @endforeach

    <button type="button" class="rounded-lg bg-zinc-900 px-5 py-3 text-sm font-semibold text-white">
        Submit
    </button>
</form>