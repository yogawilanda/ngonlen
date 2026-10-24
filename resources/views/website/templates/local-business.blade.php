@php
    $business = $content['business'] ?? [];
    $hero = $content['hero'] ?? [];
    $services = $content['services'] ?? [];
    $about = $content['about'] ?? [];
    $advantages = $content['advantages'] ?? [];
    $gallery = $content['gallery'] ?? [];
    $contact = $content['contact'] ?? [];

    $name = $business['name'] ?? 'Nama Bisnis';
    $category = $business['category'] ?? 'Bisnis Lokal';
    $location = $business['location'] ?? '';
    $whatsapp = $contact['whatsapp'] ?? '';
@endphp

<div class="min-h-screen bg-white text-zinc-900">

    {{-- Hero --}}
    <section class="border-b border-zinc-200">
        <div class="mx-auto max-w-6xl px-6 py-20 sm:py-28">
            <div class="max-w-3xl">

                <p class="mb-4 text-sm font-semibold text-sky-600">
                    {{ $category }}
                    @if ($location)
                        · {{ $location }}
                    @endif
                </p>

                <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">
                    {{ $hero['title'] ?? "Selamat datang di {$name}" }}
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-zinc-600">
                    {{ $hero['description'] ?? "Temukan layanan {$name} untuk kebutuhan Anda." }}
                </p>

                @if ($whatsapp)
                    <div class="mt-8">
                        <a
                            href="https://wa.me/{{ $whatsapp }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center rounded-lg bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800"
                        >
                            Hubungi Kami
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </section>


    {{-- About --}}
    @if (!empty($about))
        <section class="border-b border-zinc-200">
            <div class="mx-auto max-w-6xl px-6 py-16 sm:py-20">

                <div class="grid gap-10 md:grid-cols-[180px_1fr]">
                    <div>
                        <p class="text-sm font-semibold text-zinc-500">
                            Tentang
                        </p>
                    </div>

                    <div class="max-w-3xl">
                        <h2 class="text-2xl font-bold">
                            {{ $about['title'] ?? "Tentang {$name}" }}
                        </h2>

                        <p class="mt-4 leading-7 text-zinc-600">
                            {{ $about['description'] ?? '' }}
                        </p>
                    </div>
                </div>

            </div>
        </section>
    @endif


    {{-- Services --}}
    @if (count($services) > 0)
        <section class="border-b border-zinc-200">
            <div class="mx-auto max-w-6xl px-6 py-16 sm:py-20">

                <div class="max-w-2xl">
                    <p class="text-sm font-semibold text-zinc-500">
                        Layanan
                    </p>

                    <h2 class="mt-2 text-2xl font-bold">
                        Yang kami tawarkan
                    </h2>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($services as $service)
                        <article
                            class="rounded-xl border border-zinc-200 p-5"
                        >
                            <h3 class="font-semibold">
                                {{ $service['name'] ?? 'Layanan' }}
                            </h3>

                            @if (!empty($service['description']))
                                <p class="mt-2 text-sm leading-6 text-zinc-600">
                                    {{ $service['description'] }}
                                </p>
                            @endif

                            @if (!empty($service['price']))
                                <p class="mt-4 text-sm font-semibold">
                                    {{ $service['price'] }}
                                </p>
                            @endif
                        </article>
                    @endforeach

                </div>

            </div>
        </section>
    @endif


    {{-- Advantages --}}
    @if (count($advantages) > 0)
        <section class="border-b border-zinc-200">
            <div class="mx-auto max-w-6xl px-6 py-16 sm:py-20">

                <div class="max-w-2xl">
                    <p class="text-sm font-semibold text-zinc-500">
                        Kenapa kami
                    </p>

                    <h2 class="mt-2 text-2xl font-bold">
                        Dibuat untuk kebutuhan Anda
                    </h2>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-3">

                    @foreach ($advantages as $advantage)
                        <div>
                            <h3 class="font-semibold">
                                {{ $advantage['title'] ?? '' }}
                            </h3>

                            @if (!empty($advantage['description']))
                                <p class="mt-2 text-sm leading-6 text-zinc-600">
                                    {{ $advantage['description'] }}
                                </p>
                            @endif
                        </div>
                    @endforeach

                </div>

            </div>
        </section>
    @endif


    {{-- Gallery --}}
    @if (count($gallery) > 0)
        <section class="border-b border-zinc-200">
            <div class="mx-auto max-w-6xl px-6 py-16 sm:py-20">

                <div>
                    <p class="text-sm font-semibold text-zinc-500">
                        Galeri
                    </p>

                    <h2 class="mt-2 text-2xl font-bold">
                        Beberapa hasil dan aktivitas kami
                    </h2>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($gallery as $image)
                        <div class="aspect-[4/3] overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100">

                            @if (!empty($image['url']))
                                <img
                                    src="{{ $image['url'] }}"
                                    alt="{{ $image['alt'] ?? $name }}"
                                    class="h-full w-full object-cover"
                                >
                            @endif

                        </div>
                    @endforeach

                </div>

            </div>
        </section>
    @endif


    {{-- Contact --}}
    <section>
        <div class="mx-auto max-w-6xl px-6 py-20 sm:py-28">

            <div class="max-w-2xl">

                <p class="text-sm font-semibold text-sky-600">
                    Hubungi kami
                </p>

                <h2 class="mt-2 text-3xl font-bold sm:text-4xl">
                    {{ $contact['title'] ?? 'Ada yang ingin ditanyakan?' }}
                </h2>

                <p class="mt-4 leading-7 text-zinc-600">
                    {{ $contact['description'] ?? "Hubungi {$name} untuk informasi lebih lanjut." }}
                </p>

                @if ($whatsapp)
                    <div class="mt-8">
                        <a
                            href="https://wa.me/{{ $whatsapp }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center rounded-lg bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800"
                        >
                            Chat WhatsApp
                        </a>
                    </div>
                @endif

                @if (!empty($contact['address']))
                    <p class="mt-8 text-sm text-zinc-500">
                        {{ $contact['address'] }}
                    </p>
                @endif

            </div>

        </div>
    </section>


    {{-- Footer --}}
    <footer class="border-t border-zinc-200">
        <div class="mx-auto flex max-w-6xl flex-col gap-2 px-6 py-8 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">

            <p>
                © {{ now()->year }} {{ $name }}
            </p>

            <p>
                Powered by Ngonlen
            </p>

        </div>
    </footer>

</div>
