<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body class="p-0 m-0 box-border bg-yellow-50 min-h-screen">
    @yield('navbar')
    <div class="px-2 md:px-4 min-h-screen">
        @yield('content')
    </div>
</body>

</html>
