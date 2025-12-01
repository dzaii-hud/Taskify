<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (!empty($title))
            {{ $title }} - {{ config('app.name', 'Taskify') }}
        @else
            {{ config('app.name', 'Taskify') }}
        @endif
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gradient-to-br from-sky-50 via-indigo-50 to-purple-50">
    <div class="min-h-screen">
        {{-- NAVBAR --}}
        @livewire('layout.navigation')

        {{-- PAGE CONTENT --}}
        <main class="py-8 px-4">
            <div class="max-w-6xl mx-auto">
                {{ $slot ?? '' }}
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>


</html>
