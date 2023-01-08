<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
        <meta name="description" content="{{ $description ?? '' }}" />
        <meta property="og:title" content="{{ $title ?? config('app.name') }}" />
        @if (! empty($image))
            <meta property="og:image" content="{{ $image }}" />
        @endif
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ URL::current() }}" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:creator" content="@benjamincrozat" />
        <meta name="twitter:description" content="{{ $description ?? '' }}" />
        @if (! empty($image))
            <meta name="twitter:image" content="{{ $image }}" />
        @endif
        <meta name="twitter:title" content="{{ $title ?? config('app.name') }}" />

        <title>{{ $title ?? "The web developer life of Benjamin Crozat" }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if (! app()->runningUnitTests())
            @googlefonts
        @endif

        <x-feed-links />

        <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/img/apple-touch-icon.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/img/16x16.png') }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/img/32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="48x48" href="{{ Vite::asset('resources/img/48x48.png') }}" />
        <link rel="icon" type="image/png" sizes="96x96" href="{{ Vite::asset('resources/img/96x96.png') }}" />

        <link rel="canonical" href="{{ url()->current() }}" />

        @if (app()->isProduction() && auth()->guest())
            <script defer src="https://save-tonight-hey-jude.benjamincrozat.com/script.js" data-site="{{ config('services.fathom.site_id') }}"></script>
        @endif

        @stack('head')
    </head>
    <body {{ $attributes->merge(['class' => 'bg-gray-50 font-light', 'x-data' => '']) }}>
        {{ $slot }}

        @if (session('status') || request()->convertkit)
            <div
                class="fixed bottom-0 left-0 right-0 z-10"
                x-init="setTimeout(() => open = false, 5000)"
                x-data="{ open: true }"
                x-show="open"
                x-cloak
            >
                <div class="container mb-4">
                    <div class="bg-gray-800 flex items-center justify-between gap-5 px-5 py-4 rounded-lg shadow-lg text-white">
                        <p>
                            @if ('confirmed-subscription' === request()->convertkit)
                                You're all set! Thank you for subscribing!
                            @else
                                {{ session('status') }}
                            @endif
                        </p>

                        <button class="text-indigo-400" @click="open = false">
                            <span class="sr-only">Close</span>
                            <x-heroicon-o-x-mark class="w-5 h-5 translate-y-[-0.5px]" />
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="fixed inset-0 backdrop-blur-md bg-black/50 grid place-items-center dark:text-gray"
            x-cloak
            x-data="{
                open: false,
                query: '',
            }"
            x-init="$watch('open', value => $nextTick(() => { if (value) $refs.input.focus()}))"
            x-show="open"
            x-transition.opacity
            @keyup.escape.window="open = false"
            @keydown.meta.k.window="open = ! open"
        >
            <div class="container md:max-w-screen-sm" @click.away="open = false">
                <div class="bg-white dark:bg-gray-800 pb-2 rounded-lg shadow-xl">
                    <input
                        type="search"
                        x-model="query"
                        x-ref="input"
                        placeholder="How to check if a model is soft deleted?"
                        class="bg-transparent border-transparent focus:border-transparent placeholder-gray-300 dark:placeholder-gray-600 px-4 py-3 focus:ring-0 w-full"
                    />

                    <p class="text-center text-xs">
                        <a href="#">
                            <span class="opacity-50">Powered by</span> <x-icon-algolia class="h-4 inline" />
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
