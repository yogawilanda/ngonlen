<flux:card class="text-left">
    <flux:heading size="sm">
        {{ $widget['content']['title'] ?? '' }}
    </flux:heading>

    <flux:text class="mt-2">
        {{ $widget['content']['text'] ?? '' }}
    </flux:text>
</flux:card>
