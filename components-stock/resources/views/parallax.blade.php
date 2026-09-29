<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parallax Demo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black antialiased">
    <x-parallax-scrolling />

    <div class="pointer-events-none fixed bottom-0 left-0 z-999 flex h-16 w-full flex-col items-center justify-center p-4">
        <p class="pointer-events-auto text-center text-lg leading-[1.3] font-medium text-[#efeeec]/50">
            Resource by <a target="_blank" href="https://www.osmo.supply/" class="text-[#efeeec]">Osmo</a>
        </p>
    </div>
</body>
</html>