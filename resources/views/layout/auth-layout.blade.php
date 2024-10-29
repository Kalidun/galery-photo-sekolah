@extends('layout.app')

@section('content')
    <div class="flex flex-col md:flex-row justify-between py-12 h-screen px-8 gap-16">
        <div class="p-8 flex flex-col items-center justify-center md:w-1/2 rounded-lg bg-transparent">
            <img src="{{ asset('assets/images/auth-image.png') }}" class="rounded-lg">
            <div class="text-xl mb-4">Welcome to Galery App</div>
        </div>
        <div class="p-2 md:p-8 md:w-1/2 shadow bg-yellow-100 rounded-lg h-full">
            @yield('auth-content')
        </div>
    </div>
@endsection
