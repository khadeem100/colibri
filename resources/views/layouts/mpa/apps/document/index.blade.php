<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        
        @include('layouts.parts.meta')
        @include('layouts.parts.favicons')

        @vite([
            'resources/js/document/main.js',
            'resources/css/document/main.css',
            'resources/fonts/sf-pro/stylesheet.css'
        ])

        @stack('styles')
        
        @stack('scripts')
    </head>
    <body class="bg-bg-pr pt-14">
        <div class="fixed inset-0 -z-10">
            <img class="size-full object-fill opacity-30" src="{{ asset('assets/backgrounds/default.png') }}" alt="Background">
        </div>

        @include('layouts.mpa.parts.header')

        <div class="flex-col flex min-h-screen">
            <div class="flex justify-center py-12 md:py-24 flex-1">
                <div class="app-container px-4 md:px-8">
                    @yield('pageContent')
                </div>
            </div>
            @include('layouts.mpa.parts.footer')
        </div>
    </body>
</html>