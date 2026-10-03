@php
    $widgetViews = [
        'heading' => 'website.widgets.heading',
        'text' => 'website.widgets.text',
        'button' => 'website.widgets.button',
        'button-group' => 'website.widgets.button-group',
        'image' => 'website.widgets.image',
        'card' => 'website.widgets.card',
        'table' => 'website.widgets.table',
        'form' => 'website.widgets.form',
        'gallery' => 'website.widgets.gallery',
        'faq' => 'website.widgets.faq',
    ];
    $spacing = $theme['layout']['section_spacing'] ?? 'py-16 sm:py-20';
    $container = $theme['layout']['container'] ?? 'max-w-6xl';
@endphp

<section id="section-{{ $section['id'] }}" data-section-id="{{ $section['id'] }}" class="border-b border-zinc-200 {{ $spacing }}">
    <div class="mx-auto {{ $container }} space-y-6 px-5 sm:px-8">
        @foreach ($section['widgets'] ?? [] as $widget)
            @php
                $widgetView = $widgetViews[$widget['type'] ?? ''] ?? null;
            @endphp

            @if ($widgetView)
                @include($widgetView, [
                    'widget' => $widget,
                    'theme' => $theme,
                ])
            @else
                <div class="rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900" role="status">
                    Unsupported widget type: {{ $widget['type'] ?? 'unknown' }}
                </div>
            @endif
        @endforeach
    </div>
</section>