<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>@yield('title', 'Acme Store')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>...</header>
    <main>@yield('content')</main>
</body>
</html>