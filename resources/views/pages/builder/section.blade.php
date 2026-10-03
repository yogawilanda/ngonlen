{{-- resources/views/pages/builder/section.blade.php --}}
<section
    @class([
        'border-b border-zinc-200 dark:border-zinc-800',
        'bg-zinc-50 dark:bg-zinc-950' => ($section['settings']['background'] ?? null) === 'zinc-50',
        'bg-white dark:bg-zinc-900' => ($section['settings']['background'] ?? null) !== 'zinc-50',
        $theme['layout']['section_spacing'] ?? 'py-16 sm:py-20',
    ])
>
    <div
        class="mx-auto px-5 sm:px-8"
        @class([
            'text-center' => ($section['settings']['align'] ?? 'left') === 'center',
            'text-right' => ($section['settings']['align'] ?? 'left') === 'right',
        ])
    >
        @foreach ($section['widgets'] ?? [] as $widget)
            @includeIf(
                'pages.builder.widgets.' . $widget['type'],
                [
                    'widget' => $widget,
                    'theme' => $theme,
                ]
            )
        @endforeach
    </div>
</section>
