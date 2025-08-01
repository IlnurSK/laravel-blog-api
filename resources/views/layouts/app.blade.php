<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Blog API</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 text-gray-900 min-h-screen flex flex-col">

@include('partials.navbar')

@include('partials.messages')

<main class="py-8">
    <div class="max-w-screen-md mx-auto px-4">
        @yield('content')
    </div>
</main>

<footer class="bg-gray-200 text-center text-sm py-4">
    © {{ date('Y') }} Laravel Blog API. Все права защищены.
</footer>

</body>
</html>
