<?php

namespace App\Livewire\Pages\Builder;

use Livewire\Component;

class Builder extends Component
{
    public string $websiteName = 'Acme Studio';

    public string $websiteDomain = 'acme.ngonlen.test';

    public string $activePage = 'Home';

    public ?string $activeSection = 'Hero';

    public string $activeTheme = 'Minimal Studio';

    public string $activePanel = '';

    /**
     * Website configuration.
     *
     * Semua yang dirender builder berasal dari data ini.
     */
    public array $website = [
        'name' => 'Acme Studio',
        'domain' => 'acme.ngonlen.test',

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

        'pages' => [
            [
                'name' => 'Home',
                'path' => '/',

                'sections' => [
                    [
                        'id' => 'hero',
                        'type' => 'hero',
                        'name' => 'Hero',

                        'settings' => [
                            'background' => 'zinc-50',
                            'align' => 'left',
                        ],

                        'widgets' => [
                            [
                                'id' => 'hero-label',
                                'type' => 'text',
                                'content' => [
                                    'text' => 'Digital Studio',
                                ],
                                'settings' => [
                                    'style' => 'eyebrow',
                                ],
                            ],

                            [
                                'id' => 'hero-heading',
                                'type' => 'heading',
                                'content' => [
                                    'text' => 'We build simple things that work.',
                                ],
                                'settings' => [
                                    'size' => 'xl',
                                ],
                            ],

                            [
                                'id' => 'hero-description',
                                'type' => 'text',
                                'content' => [
                                    'text' => 'A clean starting point for a small business website.',
                                ],
                                'settings' => [
                                    'style' => 'body',
                                ],
                            ],

                            [
                                'id' => 'hero-actions',
                                'type' => 'button-group',
                                'content' => [
                                    'buttons' => [
                                        [
                                            'label' => 'Get started',
                                            'url' => '#',
                                            'variant' => 'primary',
                                        ],
                                        [
                                            'label' => 'Learn more',
                                            'url' => '#',
                                            'variant' => 'ghost',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],

                    [
                        'id' => 'services',
                        'type' => 'grid',
                        'name' => 'Services',

                        'settings' => [
                            'columns' => 3,
                        ],

                        'widgets' => [
                            [
                                'id' => 'service-1',
                                'type' => 'card',
                                'content' => [
                                    'title' => 'Web Design',
                                    'text' => 'Simple, responsive websites built around what your business actually needs.',
                                ],
                            ],

                            [
                                'id' => 'service-2',
                                'type' => 'card',
                                'content' => [
                                    'title' => 'Development',
                                    'text' => 'Fast and maintainable web experiences using a reusable production system.',
                                ],
                            ],

                            [
                                'id' => 'service-3',
                                'type' => 'card',
                                'content' => [
                                    'title' => 'Support',
                                    'text' => 'Keep your website updated without rebuilding everything from zero.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name' => 'About',
                'path' => '/about',

                'sections' => [
                    [
                        'id' => 'about-intro',
                        'type' => 'content',
                        'name' => 'About',

                        'settings' => [
                            'align' => 'left',
                        ],

                        'widgets' => [
                            [
                                'id' => 'about-heading',
                                'type' => 'heading',
                                'content' => [
                                    'text' => 'About us',
                                ],
                            ],

                            [
                                'id' => 'about-text',
                                'type' => 'text',
                                'content' => [
                                    'text' => 'Tell your visitors who you are and what your business does.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name' => 'Contact',
                'path' => '/contact',

                'sections' => [
                    [
                        'id' => 'contact-form',
                        'type' => 'content',
                        'name' => 'Contact',

                        'settings' => [],

                        'widgets' => [
                            [
                                'id' => 'contact-heading',
                                'type' => 'heading',
                                'content' => [
                                    'text' => 'Contact us',
                                ],
                            ],

                            [
                                'id' => 'contact-form-widget',
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
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    public array $themes = [
        'Minimal Studio',
        'Business Clean',
        'Editorial',
    ];

    public function mount(): void
    {
        $this->websiteName = $this->website['name'];
        $this->websiteDomain = $this->website['domain'];
        $this->activeTheme = $this->website['theme']['name'];

        $page = $this->currentPage();

        if ($page && ! empty($page['sections'])) {
            $this->activeSection = $page['sections'][0]['name'];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    public function openPanel(string $panel): void
    {
        $allowed = [
            'pages',
            'sections',
            'widgets',
            'theme',
            'more',
        ];

        if (! in_array($panel, $allowed, true)) {
            return;
        }

        $this->activePanel = $this->activePanel === $panel
            ? ''
            : $panel;
    }

    public function closePanel(): void
    {
        $this->activePanel = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public function selectPage(string $pageName): void
    {
        $page = collect($this->website['pages'])
            ->firstWhere('name', $pageName);

        if (! $page) {
            return;
        }

        $this->activePage = $pageName;

        $this->activeSection = ! empty($page['sections'])
            ? $page['sections'][0]['name']
            : null;

        $this->activePanel = '';

        $this->toast("Halaman {$pageName} dipilih.");
    }

    public function addPage(): void
    {
        $number = count($this->website['pages']) + 1;

        $name = "Page {$number}";
        $path = "/page-{$number}";

        $this->website['pages'][] = [
            'name' => $name,
            'path' => $path,
            'sections' => [],
        ];

        $this->activePage = $name;
        $this->activeSection = null;
        $this->activePanel = '';

        $this->toast("{$name} berhasil ditambahkan.");
    }

    /*
    |--------------------------------------------------------------------------
    | Sections
    |--------------------------------------------------------------------------
    */

    public function selectSection(string $sectionName): void
    {
        $pageIndex = $this->currentPageIndex();

        if ($pageIndex === null) {
            return;
        }

        $section = collect($this->website['pages'][$pageIndex]['sections'])
            ->firstWhere('name', $sectionName);

        if (! $section) {
            return;
        }

        $this->activeSection = $sectionName;

        $this->activePanel = '';

        $this->toast("Section {$sectionName} dipilih.");
    }

    public function addSection(): void
    {
        $pageIndex = $this->currentPageIndex();

        if ($pageIndex === null) {
            return;
        }

        $number = count($this->website['pages'][$pageIndex]['sections']) + 1;

        $section = [
            'id' => 'section-' . uniqid(),
            'type' => 'content',
            'name' => "Section {$number}",

            'settings' => [
                'align' => 'left',
            ],

            'widgets' => [],
        ];

        $this->website['pages'][$pageIndex]['sections'][] = $section;

        $this->activeSection = $section['name'];
        $this->activePanel = '';

        $this->toast("{$section['name']} berhasil ditambahkan.");
    }

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    */

    public function addWidget(string $type): void
    {
        $pageIndex = $this->currentPageIndex();

        if ($pageIndex === null || ! $this->activeSection) {
            $this->toast('Pilih section terlebih dahulu.');
            return;
        }

        $sectionIndex = $this->currentSectionIndex($pageIndex);

        if ($sectionIndex === null) {
            $this->toast('Section tidak ditemukan.');
            return;
        }

        $widget = $this->makeWidget($type);

        if (! $widget) {
            return;
        }

        $this->website['pages'][$pageIndex]['sections'][$sectionIndex]['widgets'][] = $widget;

        $this->activePanel = '';

        $this->toast("Widget {$type} ditambahkan.");
    }

    protected function makeWidget(string $type): ?array
    {
        return match ($type) {
            'heading' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'heading',
                'content' => [
                    'text' => 'Heading baru',
                ],
                'settings' => [
                    'size' => 'lg',
                ],
            ],

            'text' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'text',
                'content' => [
                    'text' => 'Tulis sesuatu di sini.',
                ],
                'settings' => [],
            ],

            'button' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'button',
                'content' => [
                    'label' => 'Button',
                    'url' => '#',
                ],
                'settings' => [
                    'variant' => 'primary',
                ],
            ],

            'image' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'image',
                'content' => [
                    'src' => null,
                    'alt' => '',
                ],
                'settings' => [],
            ],

            'card' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'card',
                'content' => [
                    'title' => 'Card title',
                    'text' => 'Card description.',
                ],
                'settings' => [],
            ],

            'table' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'table',
                'content' => [
                    'columns' => [
                        'Name',
                        'Description',
                        'Status',
                    ],
                    'rows' => [
                        [
                            'Item 1',
                            'Description',
                            'Active',
                        ],
                    ],
                ],
                'settings' => [],
            ],

            'form' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'form',
                'content' => [
                    'fields' => [
                        [
                            'name' => 'name',
                            'label' => 'Name',
                            'type' => 'text',
                            'required' => true,
                        ],
                    ],
                ],
                'settings' => [],
            ],

            'gallery' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'gallery',
                'content' => [
                    'images' => [],
                ],
                'settings' => [],
            ],

            'faq' => [
                'id' => 'widget-' . uniqid(),
                'type' => 'faq',
                'content' => [
                    'items' => [
                        [
                            'question' => 'Frequently asked question?',
                            'answer' => 'Answer goes here.',
                        ],
                    ],
                ],
                'settings' => [],
            ],

            default => null,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */

    public function selectTheme(string $theme): void
    {
        if (! in_array($theme, $this->themes, true)) {
            return;
        }

        $this->activeTheme = $theme;

        $this->website['theme']['name'] = $theme;

        $this->activePanel = '';

        $this->toast("Theme {$theme} dipilih.");
    }

    /*
    |--------------------------------------------------------------------------
    | Builder Actions
    |--------------------------------------------------------------------------
    */

    public function preview(): void
    {
        $this->toast('Preview akan membuka website dalam mode publik.');
    }

    public function save(): void
    {
        /*
         * Nanti:
         *
         * $this->website disimpan ke database.
         */
        $this->toast('Perubahan disimpan.');
    }

    public function publish(): void
    {
        /*
         * Nanti:
         *
         * website.status = published
         */
        $this->toast('Website dipublish.');
    }

    public function back(): void
    {
        $this->toast('Navigasi kembali belum dihubungkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function currentPageIndex(): ?int
    {
        foreach ($this->website['pages'] as $index => $page) {
            if ($page['name'] === $this->activePage) {
                return $index;
            }
        }

        return null;
    }

    protected function currentPage(): ?array
    {
        $index = $this->currentPageIndex();

        return $index !== null
            ? $this->website['pages'][$index]
            : null;
    }

    protected function currentSectionIndex(int $pageIndex): ?int
    {
        foreach ($this->website['pages'][$pageIndex]['sections'] as $index => $section) {
            if ($section['name'] === $this->activeSection) {
                return $index;
            }
        }

        return null;
    }

    private function toast(string $message): void
    {
        $this->dispatch(
            'builder-toast',
            message: $message,
        );
    }

    public function render()
    {
        return view('pages.builder.builder')
            ->layout('layouts.builder', [
                'title' => 'Builder',
            ]);
    }
}
