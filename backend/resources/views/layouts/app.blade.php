<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Blog API</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

@include('partials.navbar')

@include('partials.messages')

<main class="flex-grow container mx-auto px-4 py-6">
    @yield('content')
</main>

<footer class="bg-white text-center text-sm py-4 shadow-inner">
    © {{ date('Y') }} Laravel Blog API. Все права защищены.
</footer>

</body>
</html>
