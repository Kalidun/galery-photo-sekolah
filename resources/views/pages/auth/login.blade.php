@extends('layout.auth-layout')

@section('title', 'Login | Galery App')

@section('auth-content')
    <div class="p-4 md:p-16 h-full w-full flex flex-col items-center justify-center">
        <div class="flex flex-col gap-2 text-center mb-12">
            <div class="text-xl font-bold">
                Sign In
            </div>
            <div class="text-sm">
                Silahkan login terlebih dahulu
            </div>
        </div>
        <form action="{{ route('login') }}" class="w-full flex flex-col gap-2 px-2 md:px-4" method="POST">
            @csrf
            <input type="text" name="email" placeholder="Email"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none" autofocus
                value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none" required>
            <button class="w-full bg-yellow-400 text-white p-2 rounded-md mt-4 hover:bg-yellow-500 transition duration-100"
                type="submit">Sign In</button>
        </form>
        <div class="text-sm mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-500 transition duration-100"> Daftar
                disini</a>
        </div>
    </div>
    <script>
        Swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success"
        });
    </script>
@endsection
