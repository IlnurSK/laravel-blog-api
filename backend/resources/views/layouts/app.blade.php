<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Blog API</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

@include('components.navbar')

<main class="container mx-auto px-4 py-6">
    @include('components.alerts')

    @yield('content')
</main>

</body>
</html>
