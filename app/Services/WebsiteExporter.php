<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class WebsiteExporter
{
    public function export(array $website)
    {
        if (empty($website['pages']) || ! is_array($website['pages'])) {
            throw new RuntimeException('Website harus memiliki minimal satu halaman.');
        }

        if (! class_exists(ZipArchive::class)) {
            throw new RuntimeException('Ekstensi PHP ZipArchive tidak tersedia.');
        }

        $slug = Str::slug($website['name'] ?? 'website') ?: 'website';
        $token = Str::random(12);
        $workspace = storage_path("app/exports/{$slug}-{$token}");
        $zipPath = storage_path("app/exports/{$slug}-{$token}.zip");

        File::ensureDirectoryExists($workspace);
        File::ensureDirectoryExists(dirname($zipPath));

        try {
            $this->copyProject(base_path(), $workspace);

            File::ensureDirectoryExists($workspace.'/storage/app');

            File::put(
                $workspace.'/storage/app/website.json',
                json_encode(
                    $website,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                )
            );

            File::put($workspace.'/routes/web.php', <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

Route::get('/{path?}', function (?string $path = null) {
    $file = storage_path('app/website.json');

    abort_unless(is_file($file), 404);

    $website = json_decode(
        file_get_contents($file),
        true,
        512,
        JSON_THROW_ON_ERROR
    );

    $requestedPath = '/'.trim($path ?? '', '/');

    $page = collect($website['pages'] ?? [])
        ->first(fn (array $page) => ($page['path'] ?? null) === $requestedPath);

    abort_unless($page, 404);

    return view('website.shell', [
        'website' => $website,
        'pageId' => $page['id'],
    ]);
})->where('path', '.*');
PHP
);

            File::put(
                $workspace.'/README-EXPORT.md',
                "# {$website['name']}

Standalone Laravel website exported from Ngonlen.

## Installation

1. Run `composer install`.
2. Copy `.env.example` to `.env`.
3. Run `php artisan key:generate`.
4. Run `php artisan serve`.

Website content is stored in `storage/app/website.json`.
"
            );

            $zip = new ZipArchive();

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new RuntimeException('ZIP export gagal dibuat.');
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $workspace,
                    \FilesystemIterator::SKIP_DOTS
                ),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($iterator as $file) {
                if (! $file->isFile()) {
                    continue;
                }

                $absolutePath = $file->getPathname();
                $relativePath = str_replace(
                    DIRECTORY_SEPARATOR,
                    '/',
                    substr($absolutePath, strlen($workspace) + 1)
                );

                $zip->addFile($absolutePath, $relativePath);
            }

            $zip->close();

            return response()
                ->download($zipPath, "{$slug}.zip")
                ->deleteFileAfterSend(true);
        } finally {
            File::deleteDirectory($workspace);
        }
    }

    private function copyProject(string $source, string $destination): void
    {
        $excludedDirectories = [
            '.git',
            '.idea',
            '.vscode',
            'node_modules',
            'vendor',
            'tests',
            'storage',
        ];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $source,
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $absolutePath = $item->getPathname();
            $relativePath = substr($absolutePath, strlen($source) + 1);
            $segments = preg_split('~[\\\\/]~', $relativePath);

            if (array_intersect($segments, $excludedDirectories)) {
                continue;
            }

            if ($relativePath === '.env' || $relativePath === 'public/hot') {
                continue;
            }

            if (
                str_starts_with($relativePath, 'bootstrap/cache/')
                && $item->isFile()
                && $item->getExtension() === 'php'
            ) {
                continue;
            }

            $target = $destination.DIRECTORY_SEPARATOR.$relativePath;

            if ($item->isDir()) {
                File::ensureDirectoryExists($target);
                continue;
            }

            File::ensureDirectoryExists(dirname($target));
            File::copy($absolutePath, $target);
        }
    }
}
