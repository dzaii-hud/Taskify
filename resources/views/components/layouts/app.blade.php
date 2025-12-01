<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Taskify') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">

    {{-- Navbar Livewire (opsional) --}}
    @includeIf('livewire.layout.navigation')

    <main class="min-h-screen p-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
