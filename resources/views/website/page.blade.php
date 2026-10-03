<main id="page-{{ $page['id'] }}" data-page-id="{{ $page['id'] }}">
    @foreach ($page['sections'] ?? [] as $section)
        @include('website.section', [
            'section' => $section,
            'theme' => $theme,
        ])
    @endforeach
</main>