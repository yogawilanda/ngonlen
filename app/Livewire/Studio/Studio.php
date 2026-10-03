<?php

namespace App\Livewire\Studio;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class Studio extends Component
{
    public array $website = [];

    public string $activePage = '';

    public ?string $activeSection = null;

    public ?string $activeWidget = null;

    public string $activePanel = 'pages';

    public string $activeTheme = '';

    /**
     * @var array<string, array{colors: array<string, string>, typography: array<string, string>}>
     */
    private array $themes = [
        'Minimal Studio' => [
            'colors' => [
                'primary' => 'sky',
                'background' => 'white',
                'surface' => 'zinc-50',
                'text' => 'zinc-900',
                'muted' => 'zinc-500',
            ],
            'typography' => [
                'font' => 'sans',
                'heading' => 'font-bold',
                'body' => 'leading-relaxed',
            ],
        ],
        'Business Clean' => [
            'colors' => [
                'primary' => 'emerald',
                'background' => 'white',
                'surface' => 'zinc-50',
                'text' => 'zinc-900',
                'muted' => 'zinc-500',
            ],
            'typography' => [
                'font' => 'sans',
                'heading' => 'font-semibold',
                'body' => 'leading-relaxed',
            ],
        ],
        'Editorial' => [
            'colors' => [
                'primary' => 'violet',
                'background' => 'white',
                'surface' => 'zinc-50',
                'text' => 'zinc-900',
                'muted' => 'zinc-500',
            ],
            'typography' => [
                'font' => 'serif',
                'heading' => 'font-semibold',
                'body' => 'leading-relaxed',
            ],
        ],
    ];

    public function mount(): void
    {
        $this->website = $this->defaultWebsite();
        $this->activePage = $this->website['pages'][0]['id'];
        $this->activeSection = $this->website['pages'][0]['sections'][0]['id'] ?? null;
        $this->activeTheme = $this->website['theme']['name'];
    }

    public function openPanel(string $panel): void
    {
        if (!in_array($panel, ['pages', 'sections', 'widgets', 'theme'], true)) {
            return;
        }

        $this->activePanel = $this->activePanel === $panel ? '' : $panel;
    }

    public function selectPage(string $pageId): void
    {
        $page = collect($this->website['pages'])->firstWhere('id', $pageId);

        if (!$page) {
            return;
        }

        $this->activePage = $pageId;
        $this->activeSection = $page['sections'][0]['id'] ?? null;
        $this->activeWidget = null;
        $this->activePanel = '';
    }

    public function addPage(string $name, string $path = ''): void
    {
        $name = trim($name);

        if ($name === '') {
            return;
        }

        $path = trim($path);

        if ($path === '') {
            $path = '/' . \Illuminate\Support\Str::slug($name);
        } else {
            $path = '/' . ltrim($path, '/');
        }

        $existingPaths = collect($this->website['pages'])
            ->pluck('path')
            ->map(fn($value) => strtolower($value))
            ->all();

        if (in_array(strtolower($path), $existingPaths, true)) {
            $basePath = $path;
            $counter = 2;

            while (in_array(strtolower($path), $existingPaths, true)) {
                $path = $basePath . '-' . $counter++;
            }
        }

        $id = \Illuminate\Support\Str::slug($name);

        $existingIds = collect($this->website['pages'])
            ->pluck('id')
            ->all();

        $baseId = $id;
        $counter = 2;

        while (in_array($id, $existingIds, true)) {
            $id = $baseId . '-' . $counter++;
        }

        $this->website['pages'][] = [
            'id' => $id,
            'name' => $name,
            'path' => $path,
            'sections' => [],
        ];

        $this->activePage = $id;
        $this->activeSection = null;
        $this->activeWidget = null;

        $this->toast("Page \"{$name}\" created.");
    }

    public function renamePage(
        string $pageId,
        string $name,
        string $path = ''
    ): void {
        $name = trim($name);

        if ($name === '') {
            return;
        }

        $pageIndex = $this->pageIndex($pageId);

        if ($pageIndex === null) {
            return;
        }

        $currentPath = $this->website['pages'][$pageIndex]['path'];

        // Home tetap menjadi root.
        if ($currentPath === '/') {
            $path = '/';
        } else {
            $path = trim($path);

            if ($path === '') {
                $path = '/' . Str::slug($name);
            } else {
                $path = '/' . ltrim($path, '/');
            }
        }

        foreach ($this->website['pages'] as $index => $page) {
            if ($index === $pageIndex) {
                continue;
            }

            if (strtolower($page['path']) === strtolower($path)) {
                $this->toast('That URL is already used by another page.');

                return;
            }
        }

        $this->website['pages'][$pageIndex]['name'] = $name;
        $this->website['pages'][$pageIndex]['path'] = $path;

        $this->toast("Page \"{$name}\" updated.");
    }

    public function duplicatePage(string $pageId): void
    {
        $pageIndex = $this->pageIndex($pageId);

        if ($pageIndex === null) {
            return;
        }

        $source = $this->website['pages'][$pageIndex];

        $name = $source['name'] . ' Copy';
        $id = \Illuminate\Support\Str::slug($name);

        $existingIds = collect($this->website['pages'])
            ->pluck('id')
            ->all();

        $baseId = $id;
        $counter = 2;

        while (in_array($id, $existingIds, true)) {
            $id = $baseId . '-' . $counter++;
        }

        $path = rtrim($source['path'], '/') . '-copy';

        if ($source['path'] === '/') {
            $path = '/home-copy';
        }

        $existingPaths = collect($this->website['pages'])
            ->pluck('path')
            ->map(fn($value) => strtolower($value))
            ->all();

        $basePath = $path;
        $counter = 2;

        while (in_array(strtolower($path), $existingPaths, true)) {
            $path = $basePath . '-' . $counter++;
        }

        $copy = $source;

        $copy['id'] = $id;
        $copy['name'] = $name;
        $copy['path'] = $path;

        $this->website['pages'][] = $copy;

        $this->activePage = $id;
        $this->activeSection = null;
        $this->activeWidget = null;

        $this->toast("Page \"{$name}\" duplicated.");
    }

    public function deletePage(string $pageId): void
    {
        $pageIndex = $this->pageIndex($pageId);

        if ($pageIndex === null) {
            return;
        }

        $page = $this->website['pages'][$pageIndex];

        // Home is protected.
        if ($page['path'] === '/') {
            $this->toast('The Home page cannot be deleted.');

            return;
        }

        unset($this->website['pages'][$pageIndex]);

        $this->website['pages'] = array_values($this->website['pages']);

        // If deleted page was active, select Home.
        if ($this->activePage === $pageId) {
            $home = collect($this->website['pages'])
                ->firstWhere('path', '/');

            $this->activePage = $home['id'] ?? '';

            $this->activeSection = null;
            $this->activeWidget = null;
        }

        $this->toast("Page \"{$page['name']}\" deleted.");
    }

    public function selectSection(string $sectionId): void
    {   // ini juga yang menyebabkan hydration bug
        $pageIndex = $this->currentPageIndex();

        if ($pageIndex === null || $this->currentSectionIndex($pageIndex, $sectionId) === null) {
            return;
        }

        $this->activeSection = $sectionId;
        $this->activeWidget = null;
        $this->activePanel = '';
    }

    private function pageIndex(string $pageId): ?int
    {
        foreach ($this->website['pages'] as $index => $page) {
            if ($page['id'] === $pageId) {
                return $index;
            }
        }

        return null;
    }

    public function addSection(): void
    {
        $pageIndex = $this->currentPageIndex();

        if ($pageIndex === null) {
            return;
        }

        $section = [
            'id' => (string) Str::uuid(),
            'settings' => [],
            'widgets' => [],
        ];

        $this->website['pages'][$pageIndex]['sections'][] = $section;
        $this->activeSection = $section['id'];
        $this->activeWidget = null;
        $this->activePanel = 'sections';

        $this->toast('Section berhasil ditambahkan.');
    }

    public function selectWidget(string $widgetId): void
    {
        $pageIndex = $this->currentPageIndex();
        $sectionIndex = $pageIndex === null ? null : $this->currentSectionIndex($pageIndex, $this->activeSection);

        if ($pageIndex === null || $sectionIndex === null) {
            return;
        }

        $widget = collect($this->website['pages'][$pageIndex]['sections'][$sectionIndex]['widgets'])
            ->firstWhere('id', $widgetId);

        if (!$widget) {
            return;
        }

        $this->activeWidget = $widgetId;
        $this->activePanel = 'widgets';
    }

    public function addWidget(string $type): void
    {
        $pageIndex = $this->currentPageIndex();
        $sectionIndex = $pageIndex === null ? null : $this->currentSectionIndex($pageIndex, $this->activeSection);

        if ($pageIndex === null || $sectionIndex === null) {
            $this->toast('Pilih section terlebih dahulu.');

            return;
        }

        $widget = $this->makeWidget($type);

        if ($widget === null) {
            $this->toast("Widget {$type} tidak tersedia.");

            return;
        }

        $this->website['pages'][$pageIndex]['sections'][$sectionIndex]['widgets'][] = $widget;
        $this->activeWidget = $widget['id'];
        $this->activePanel = 'widgets';

        $this->toast('Widget berhasil ditambahkan.');
    }

    public function selectTheme(string $theme): void
    {
        if (!isset($this->themes[$theme])) {
            return;
        }

        $this->activeTheme = $theme;
        $this->website['theme'] = array_replace_recursive(
            $this->website['theme'],
            $this->themes[$theme],
            ['name' => $theme],
        );
        $this->activePanel = 'theme';

        $this->toast("Theme {$theme} dipilih.");
    }

    private function defaultWebsite(): array
    {
        return [
            'id' => 'acme-studio',
            'name' => 'Acme Studio',
            'domain' => 'ngonlen.com',
            'theme' => [
                'name' => 'Minimal Studio',
                'colors' => [
                    'primary' => 'sky',
                    'background' => 'white',
                    'surface' => 'zinc-50',
                    'text' => 'zinc-900',
                    'muted' => 'zinc-500',
                ],
                'typography' => [
                    'font' => 'sans',
                    'heading' => 'font-bold',
                    'body' => 'leading-relaxed',
                ],
                'layout' => [
                    'radius' => 'rounded-lg',
                    'section_spacing' => 'py-16 sm:py-20',
                    'container' => 'max-w-6xl',
                ],
            ],
            'navigation' => [
                'items' => [
                    ['label' => 'Home', 'page' => 'home'],
                    ['label' => 'About', 'page' => 'about'],
                    ['label' => 'Contact', 'page' => 'contact'],
                ],
            ],
            'pages' => [
                [
                    'id' => 'home',
                    'name' => 'Home',
                    'path' => '/',
                    'sections' => [
                        [
                            'id' => 'home-intro',
                            'settings' => ['align' => 'left'],
                            'widgets' => [
                                [
                                    'id' => 'home-label',
                                    'type' => 'text',
                                    'content' => ['text' => 'Digital Studio'],
                                    'settings' => ['style' => 'eyebrow'],
                                ],
                                [
                                    'id' => 'home-heading',
                                    'type' => 'heading',
                                    'content' => ['text' => 'We build simple things that work.'],
                                    'settings' => ['size' => 'xl'],
                                ],
                                [
                                    'id' => 'home-description',
                                    'type' => 'text',
                                    'content' => ['text' => 'A clean starting point for a small business website.'],
                                    'settings' => [],
                                ],
                                [
                                    'id' => 'home-actions',
                                    'type' => 'button-group',
                                    'content' => [
                                        'buttons' => [
                                            ['label' => 'Get started', 'url' => '#', 'variant' => 'primary'],
                                            ['label' => 'Learn more', 'url' => '#', 'variant' => 'ghost'],
                                        ],
                                    ],
                                    'settings' => [],
                                ],
                            ],
                        ],
                        [
                            'id' => 'home-services',
                            'settings' => [],
                            'widgets' => [
                                [
                                    'id' => 'service-design',
                                    'type' => 'card',
                                    'content' => [
                                        'title' => 'Web Design',
                                        'text' => 'Simple, responsive websites built around what your business needs.',
                                    ],
                                    'settings' => [],
                                ],
                                [
                                    'id' => 'service-development',
                                    'type' => 'card',
                                    'content' => [
                                        'title' => 'Development',
                                        'text' => 'Fast and maintainable web experiences with a reusable system.',
                                    ],
                                    'settings' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'id' => 'about',
                    'name' => 'About',
                    'path' => '/about',
                    'sections' => [
                        [
                            'id' => 'about-intro',
                            'settings' => [],
                            'widgets' => [
                                [
                                    'id' => 'about-heading',
                                    'type' => 'heading',
                                    'content' => ['text' => 'About us'],
                                    'settings' => [],
                                ],
                                [
                                    'id' => 'about-text',
                                    'type' => 'text',
                                    'content' => ['text' => 'Tell your visitors who you are and what your business does.'],
                                    'settings' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'id' => 'contact',
                    'name' => 'Contact',
                    'path' => '/contact',
                    'sections' => [
                        [
                            'id' => 'contact-details',
                            'settings' => [],
                            'widgets' => [
                                [
                                    'id' => 'contact-heading',
                                    'type' => 'heading',
                                    'content' => ['text' => 'Contact us'],
                                    'settings' => [],
                                ],
                                [
                                    'id' => 'contact-form',
                                    'type' => 'form',
                                    'content' => [
                                        'fields' => [
                                            [
                                                'name' => 'name',
                                                'label' => 'Name',
                                                'type' => 'text',
                                                'required' => true,
                                            ],
                                            [
                                                'name' => 'email',
                                                'label' => 'Email',
                                                'type' => 'email',
                                                'required' => true,
                                            ],
                                            [
                                                'name' => 'message',
                                                'label' => 'Message',
                                                'type' => 'textarea',
                                                'required' => true,
                                            ],
                                        ],
                                    ],
                                    'settings' => [],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array{id: string, type: string, content: array<string, mixed>, settings: array<string, mixed>}|null
     */
    private function makeWidget(string $type): ?array
    {
        $content = match ($type) {
            'heading', 'text' => ['text' => $type === 'heading' ? 'Heading baru' : 'Tulis sesuatu di sini.'],
            'button' => ['label' => 'Button', 'url' => '#'],
            'button-group' => [
                'buttons' => [
                    ['label' => 'Button 1', 'url' => '#', 'variant' => 'primary'],
                    ['label' => 'Button 2', 'url' => '#', 'variant' => 'ghost'],
                ],
            ],
            'image' => ['src' => '', 'alt' => ''],
            'card' => ['title' => 'Card title', 'text' => 'Card description.'],
            'table' => [
                'columns' => ['Name', 'Description', 'Status'],
                'rows' => [['Item 1', 'Description', 'Active']],
            ],
            'form' => [
                'fields' => [
                    ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                ],
            ],
            'gallery' => ['images' => ['']],
            'faq' => [
                'items' => [
                    ['question' => 'Frequently asked question?', 'answer' => 'Answer goes here.'],
                ],
            ],
            default => null,
        };

        if ($content === null) {
            return null;
        }

        return [
            'id' => (string) Str::uuid(),
            'type' => $type,
            'content' => $content,
            'settings' => [],
        ];
    }

    /**
     * @param  array<string, mixed>  $widget
     * @return array<int, array{label: string, path: string, value: string}>
     */
    private function widgetEditorFields(array $widget): array
    {
        $paths = match ($widget['type']) {
            'heading', 'text' => [['Text', 'text']],
            'button' => [['Label', 'label'], ['Link URL', 'url']],
            'button-group' => [['First button label', 'buttons.0.label'], ['First button URL', 'buttons.0.url']],
            'image' => [['Image URL', 'src'], ['Alternative text', 'alt']],
            'card' => [['Title', 'title'], ['Text', 'text']],
            'table' => [['First column heading', 'columns.0']],
            'form' => [['First field label', 'fields.0.label']],
            'gallery' => [['First image URL', 'images.0']],
            'faq' => [['Question', 'items.0.question'], ['Answer', 'items.0.answer']],
            default => [],
        };

        return array_map(
            fn(array $field): array => [
                'label' => $field[0],
                'path' => $field[1],
                'value' => (string) data_get($widget['content'], $field[1], ''),
            ],
            $paths,
        );
    }

    private function currentPageIndex(): ?int
    {
        foreach ($this->website['pages'] as $index => $page) {
            if ($page['id'] === $this->activePage) {
                return $index;
            }
        }

        return null;
    }

    private function currentSectionIndex(int $pageIndex, ?string $sectionId): ?int
    {
        if ($sectionId === null) {
            return null;
        }

        foreach ($this->website['pages'][$pageIndex]['sections'] as $index => $section) {
            if ($section['id'] === $sectionId) {
                return $index;
            }
        }

        return null;
    }

    private function currentWidgetIndex(int $pageIndex, int $sectionIndex): ?int
    {
        foreach ($this->website['pages'][$pageIndex]['sections'][$sectionIndex]['widgets'] as $index => $widget) {
            if ($widget['id'] === $this->activeWidget) {
                return $index;
            }
        }

        return null;
    }



    private function toast(string $message): void
    {
        $this->dispatch('studio-toast', message: $message);
    }

    public function render(): View
    {
        $pageIndex = $this->currentPageIndex();
        $currentPage = $pageIndex === null ? null : $this->website['pages'][$pageIndex];
        $sectionIndex = $pageIndex === null ? null : $this->currentSectionIndex($pageIndex, $this->activeSection);
        $currentSection = $sectionIndex === null ? null : $currentPage['sections'][$sectionIndex];
        $widgetIndex = $pageIndex === null || $sectionIndex === null
            ? null
            : $this->currentWidgetIndex($pageIndex, $sectionIndex);
        $currentWidget = $widgetIndex === null ? null : $currentSection['widgets'][$widgetIndex];
        $currentWidgetFields = $currentWidget === null ? [] : $this->widgetEditorFields($currentWidget);
        $currentPageIndex = $pageIndex;
        $currentSectionIndex = $sectionIndex;
        $currentWidgetIndex = $widgetIndex;
        $availableThemes = array_keys($this->themes);

        return view('studio.index', compact(
            'availableThemes',
            'currentPage',
            'currentPageIndex',
            'currentSection',
            'currentSectionIndex',
            'currentWidget',
            'currentWidgetFields',
            'currentWidgetIndex',
        ))
            ->layout('layouts.studio', [
                'title' => 'Studio',
            ]);
    }
}
