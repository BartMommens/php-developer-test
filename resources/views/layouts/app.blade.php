<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <!-- Styles -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    @yield('content')

<footer class="text-muted">
    <div class="container d-flex p-4 justify-content-center">
        <p>Nasa's APOD Service !</p>
    </div>
</footer>
    @yield('scripts')
</body>
</html>
