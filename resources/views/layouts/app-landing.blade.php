{{-- resources/views/layouts/app-landing.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    {{-- favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('icon-reka.ico') }}">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50 antialiased">
    @yield('content')
</body>
</html>
