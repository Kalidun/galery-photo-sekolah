@extends('layout.app-layout')
@section('title', 'Profile Settings | Gallery App')
@section('page-title', 'Profile')
@section('page-subtitle', 'Settings')
@section('main-content')
    <div class="p-4 w-full flex flex-col gap-4 h-full max-h-[90vh] overflow-y-auto">
        <div class="flex flex-col lg:flex-row gap-4 justify-between">
            <div class="p-4 w-full lg:w-1/2 bg-yellow-100 rounded border-2 border-yellow-200">
                <div class="text-md w-full border-b-2 border-yellow-300 pb-2 mb-4">Change Your Name and Email</div>
                <form action="{{ route('profile.settings.update-name') }}" class="w-full flex flex-col gap-2" method="POST">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none"
                            placeholder="Name" autofocus autocomplete="off" value="{{ $name}}">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email"
                            class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none"
                            placeholder="Email" autocomplete="off" value="{{ $email }}" readonly>
                    </div>
                    <button type="submit"
                        class="w-full lg:w-1/3 bg-yellow-400 text-white p-2 rounded-md mt-4 hover:bg-yellow-500 transition duration-100">Save</button>
                </form>
            </div>
            <div class="p-4 w-full lg:w-1/2 bg-yellow-100 rounded border-2 border-yellow-200">
                <div class="text-md w-full border-b-2 border-yellow-300 pb-2 mb-4">Change Your Password</div>
                <form action="{{ route('profile.settings.update-password')}}" method="POST" class="w-full flex flex-col gap-2">
                    @csrf
                    <div class="flex flex-col gap-2 relative">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none"
                            placeholder="Password" autocomplete="off">
                        <button type="button" id="toggle-password" class="absolute right-2 top-9 text-gray-500">
                            Show
                        </button>
                    </div>
                    <div class="flex flex-col gap-2 relative">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm-password"
                            class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none"
                            placeholder="Confirm Password" autocomplete="off">
                        <button type="button" id="toggle-confirm-password" class="absolute right-2 top-9 text-gray-500">
                            Show
                        </button>
                    </div>
                    <button type="submit"
                        class="w-full lg:w-1/3 bg-yellow-400 text-white p-2 rounded-md mt-4 hover:bg-yellow-500 transition duration-100">Save</button>
                </form>
            </div>
        </div>
        <form action="{{ route('profile.settings.destroy')}}" method="POST">
            @csrf
            <button id="delete-account" class="w-full md:w-1/6 bg-red-400 text-white p-2 rounded-md mt-4 hover:bg-red-500 transition duration-100">Delete Account</button>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm-password');
            const togglePasswordButton = document.getElementById('toggle-password');
            const toggleConfirmPasswordButton = document.getElementById('toggle-confirm-password');

            togglePasswordButton.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePasswordButton.textContent = type === 'password' ? 'Show' : 'Hide';
            });

            toggleConfirmPasswordButton.addEventListener('click', () => {
                const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
                confirmPasswordInput.type = type;
                toggleConfirmPasswordButton.textContent = type === 'password' ? 'Show' : 'Hide';
            });
        });
    </script>
@endsection
