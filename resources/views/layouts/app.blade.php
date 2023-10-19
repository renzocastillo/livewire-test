<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <livewire:styles/>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
</head>
<body>
    @yield('content')
    <livewire:scripts/>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
</body>
</html>
