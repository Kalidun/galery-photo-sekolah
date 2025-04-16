@extends('layout.app-layout')

@section('title', 'Profile Edit | Galery App')

@section('page-title', 'Profile')

@section('page-subtitle', 'Edit')

@section('main-content')
    <div class="p-4 w-full flex flex-col gap-4">
        <form action="{{ route('profile.update') }}" class="flex flex-col md:flex-row justify-between gap-4" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div id="profile-image" class="w-full md:w-1/3 relative">
                <input type="file" accept="image/*" name="profile_image" id="profile-image-input"
                    class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none">
                <div id="preview-image" class="relative hidden">
                    <img src="" alt="Preview" class="w-full h-auto rounded-md">
                    <button type="button" id="remove-image"
                        class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center text-white text-2xl font-bold opacity-0 hover:opacity-100">
                        &times;
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-2 w-full md:w-2/3">
                <div class="flex flex-col gap-1">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ $name }}" placeholder="Name"
                        class="px-2 py-1 border border-gray-300 rounded-md" autocomplete="off">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="bio">Bio</label>
                    <input type="text" name="bio" id="bio" value="{{ $bio }}" placeholder="Bio"
                        class="px-2 py-1 border border-gray-300 rounded-md" autocomplete="off">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="birthday">Birthday</label>
                    <input type="date" name="birthday" id="birthday" value="{{ $birthday }}" placeholder="Birthday"
                        class="px-2 py-1 border border-gray-300 rounded-md" max="{{ date('Y-m-d') }}">
                </div>
                <div class="flex flex-col gap-1 md:w-1/4">
                    <label for="gender">Gender</label>
                    <select class="px-2 py-1 border border-gray-300 rounded-md" name="gender" id="gender"
                        value="{{ $gender }}">
                        <option value="-" selected disabled>Select Gender</option>
                        <option value="MALE">Male</option>
                        <option value="FEMALE">Female</option>
                        <option value="OTHER">Other</option>
                    </select>
                </div>
                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded-md w-full md:w-1/4 hover:bg-blue-600">Simpan</button>
            </div>
        </form>
        <form action="{{ route('profile.delete-profile') }}" method="POST" class="w-full flex flex-col gap-2" onsubmit="return confirm('Are you sure you want to delete your account?')}}">
            @csrf
            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded-md w-full md:w-1/6 justify-self-end hover:bg-red-600 self-end">Remove Current Photo</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageInput = document.getElementById('profile-image-input');
            const previewContainer = document.getElementById('preview-image');
            const previewImage = previewContainer.querySelector('img');
            const removeButton = document.getElementById('remove-image');

            imageInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        previewImage.src = reader.result;
                        previewContainer.classList.remove('hidden');
                        imageInput.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeButton.addEventListener('click', () => {
                previewContainer.classList.add('hidden');
                previewImage.src = '';
                imageInput.value = '';
                imageInput.classList.remove('hidden');
            });
        });
    </script>
@endsection
