<?php

namespace App\Livewire\Pages\Builder;

use Livewire\Component;

class Builder extends Component
{
    public string $websiteName = 'Acme Studio';

    public string $websiteDomain = 'acme.ngonlen.test';

    public string $activePage = 'Home';

    public string $activeSection = 'Hero';

    public string $activeTheme = 'Minimal Studio';

    public array $pages = [
        [
            'name' => 'Home',
            'path' => '/',
        ],
        [
            'name' => 'About',
            'path' => '/about',
        ],
        [
            'name' => 'Contact',
            'path' => '/contact',
        ],
    ];

    public array $sections = [
        'Hero',
        'Services',
        'About',
        'Contact',
    ];

    public array $themes = [
        'Minimal Studio',
        'Business Clean',
        'Editorial',
    ];

    public function selectPage(string $page): void
    {
        if (! collect($this->pages)->contains('name', $page)) {
            return;
        }

        $this->activePage = $page;

        $this->toast("Halaman {$page} dipilih.");
    }

    public function selectSection(string $section): void
    {
        if (! in_array($section, $this->sections, true)) {
            return;
        }

        $this->activeSection = $section;

        $this->toast("Section {$section} dipilih.");
    }

    public function addPage(): void
    {
        $number = count($this->pages) + 1;

        $name = "Page {$number}";
        $path = '/page-' . $number;

        $this->pages[] = [
            'name' => $name,
            'path' => $path,
        ];

        $this->activePage = $name;

        $this->toast("{$name} berhasil ditambahkan.");
    }

    public function addSection(): void
    {
        $available = [
            'Gallery',
            'Testimonials',
            'Pricing',
            'FAQ',
            'CTA',
        ];

        $section = collect($available)
            ->first(fn (string $item) => ! in_array($item, $this->sections, true));

        if (! $section) {
            $this->toast('Semua section demo sudah ditambahkan.');

            return;
        }

        $this->sections[] = $section;
        $this->activeSection = $section;

        $this->toast("Section {$section} berhasil ditambahkan.");
    }

    public function selectTheme(string $theme): void
    {
        if (! in_array($theme, $this->themes, true)) {
            return;
        }

        $this->activeTheme = $theme;

        $this->toast("Theme {$theme} dipilih.");
    }

    public function preview(): void
    {
        $this->toast('Preview belum terhubung ke halaman publik.');
    }

    public function save(): void
    {
        $this->toast('Perubahan sementara disimpan di state builder.');
    }

    public function publish(): void
    {
        $this->toast('Publish belum terhubung ke persistence.');
    }

    public function back(): void
    {
        $this->toast('Navigasi kembali belum dihubungkan.');
    }

    private function toast(string $message): void
    {
        $this->dispatch('builder-toast', message: $message);
    }

    public function render()
    {
        return view('pages.builder.builder')
            ->layout('layouts.app', [
                'title' => 'Builder',
            ]);
    }
}
