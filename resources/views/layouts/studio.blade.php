{{-- resources/views/layouts/studio.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    @vite(['resources/js/studio/studio.js'])
</head>

<body class="min-h-screen overflow-hidden bg-zinc-100 dark:bg-zinc-950">
    {{ $slot }}

    @fluxScripts
</body>
</html>
