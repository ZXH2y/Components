<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Radial Orbital Timeline Demo</title>
    @vite('resources/css/app.css')
    {{-- Kalau project belum pakai Alpine.js, load lewat CDN seperti ini: --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <x-radial-orbital-timeline :items="[
        [
            'id' => 1,
            'title' => 'Dompet Umkm',
            'date' => 'Jan 2026',
            'content' => 'Pastikan pengeluaran mu tidak boncos.',
            'icon' => 'calendar',
            'relatedIds' => [2],
            'status' => 'completed',
            'energy' => 100,
        ],
        [
            'id' => 2,
            'title' => 'Galung Meloang',
            'date' => 'Feb 2024',
            'content' => 'UI/UX design and system architecture.',
            'icon' => 'file-text',
            'relatedIds' => [1, 3],
            'status' => 'completed',
            'energy' => 90,
        ],
        [
            'id' => 3,
            'title' => 'About me',
            'date' => 'Mar 2024',
            'content' => 'Core features implementation and testing.',
            'icon' => 'code',
            'relatedIds' => [2, 4],
            'status' => 'in-progress',
            'energy' => 60,
        ],
        [
            'id' => 4,
            'title' => 'Guide',
            'date' => 'Apr 2024',
            'content' => 'User testing and bug fixes.',
            'icon' => 'user',
            'relatedIds' => [3, 5],
            'status' => 'pending',
            'energy' => 30,
        ],
        [
            'id' => 5,
            'title' => 'Cukimai',
            'date' => 'May 2024',
            'content' => 'Final deployment and release.',
            'icon' => 'clock',
            'relatedIds' => [4],
            'status' => 'pending',
            'energy' => 10,
        ],
    ]" />

</body>
</html>