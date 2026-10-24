@php
    $colors = $theme['colors'] ?? [];

    $palette = [
        'sky' => '#0284c7',
        'emerald' => '#059669',
        'violet' => '#7c3aed',
        'white' => '#ffffff',
        'zinc-50' => '#fafafa',
        'zinc-500' => '#71717a',
        'zinc-900' => '#18181b',
    ];

    $resolveColor = static function (string $value, string $fallback) use ($palette): string {
        if (preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
            return $value;
        }

        return $palette[$value] ?? $fallback;
    };

    $primary = $resolveColor($colors['primary'] ?? 'sky', '#0284c7');
    $background = $resolveColor($colors['background'] ?? 'white', '#ffffff');
    $surface = $resolveColor($colors['surface'] ?? 'zinc-50', '#fafafa');
    $text = $resolveColor($colors['text'] ?? 'zinc-900', '#18181b');
    $muted = $resolveColor($colors['muted'] ?? 'zinc-500', '#71717a');
@endphp

<style>
    .website-theme {
        --website-primary: {{ $primary }};
        --website-background: {{ $background }};
        --website-surface: {{ $surface }};
        --website-text: {{ $text }};
        --website-muted: {{ $muted }};
    }

    .website-theme {
        background-color: var(--website-background);
        color: var(--website-text);
    }

    .website-theme .theme-primary {
        background-color: var(--website-primary);
        color: #fff;
    }

    .website-theme .theme-surface {
        background-color: var(--website-surface);
    }

    .website-theme .theme-text {
        color: var(--website-text);
    }

    .website-theme .theme-muted {
        color: var(--website-muted);
    }

    .website-theme .theme-border {
        border-color: color-mix(in srgb, var(--website-text) 14%, transparent);
    }

    .website-theme .theme-link:hover {
        color: var(--website-primary);
    }
</style>
