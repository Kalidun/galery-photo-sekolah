<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
</head>

<body class="p-0 m-0 box-border bg-yellow-50 min-h-screen" style="max-height: 100vh !important">
    <div id="toastr-container" class="fixed top-4 right-4 space-y-2 z-50"></div>
    @yield('navbar')
    <div class="flex h-[92.7vh]">
        @yield('sidebar')
        <div class="px-2 md:px-12 py-4 w-full">
            @yield('content')
        </div>
    </div>
</body>
<script src="https://kit.fontawesome.com/f9dc9fae33.js" crossorigin="anonymous"></script>
@include('components.toast')

</html>
