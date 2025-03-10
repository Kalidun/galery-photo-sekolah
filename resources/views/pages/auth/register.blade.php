@extends('layout.auth-layout')

@section('title', 'Register | Galery App')

@section('auth-content')
    <div class="p-4 md:p-16 h-full w-full flex flex-col items-center justify-center">
        <div class="flex flex-col gap-2 text-center mb-12">
            <div class="text-xl font-bold">
                Register
            </div>
            <div class="text-sm">
                Silahkan daftar terlebih dahulu
            </div>
        </div>
        @if (session()->has('error'))
            <div class="w-full flex flex-col gap-2 px-2 md:px-4"></div>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST" class="w-full flex flex-col gap-2 px-2 md:px-4">
            @csrf
            <input type="text" name="name" placeholder="Name"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none" autofocus>
            <input type="text" name="email" placeholder="Email"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none" autofocus>
            <input type="password" name="password" placeholder="Password"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none">
            <button class="w-full bg-yellow-400 text-white p-2 rounded-md mt-4 hover:bg-yellow-500 transition duration-100"
                type="submit">Register</button>
        </form>
        <div class="text-sm mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-500 transition duration-100"> Masuk</a>
        </div>
    </div>
@endsection
