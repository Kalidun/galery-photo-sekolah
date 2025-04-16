@extends('layout.app-layout')

@section('title', 'Edit | Gallery App')

@section('page-title', 'Edit')

@section('content')
    <form action="{{ route('photos.update', $photo->id) }}" class="flex gap-8 w-full max-h-[90vh] overflow-y-auto"
        method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf

        <div class="flex flex-col gap-2 w-1/4 h-full overflow-auto">
            <img src="{{ asset('storage/images/' . $photo->image) }}"
                class="w-full max-h-[30rem] overflow-auto p-2 border border-gray-300 rounded-md text-center bg-white">
            <label for="image">Input Image below to change it</label>
            <input type="file" accept="image/*" name="image" id="image"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none">

            <div id="preview-image"
                class="w-full max-h-[30rem] overflow-auto p-2 border border-gray-300 rounded-md text-center bg-white mb-4">
                Preview Image
            </div>
            <label for="album">Album Penyimpanan</label>
            <select name="album_id" id="album" class="p-2 border border-gray-300 rounded-md w-full bg-white">
                @forelse($albumData as $album)
                    <option value="{{ $album->id }}" {{ $photo->album_id == $album->id ? 'selected' : '' }}>{{ $album->name }}</option>
                @empty
                @endforelse
            </select>
            <div class="flex gap-2">
                <div class="flex gap-2 items-center">
                    <input type="radio" id="private" name="is_public" value="0"
                        {{ $photo->is_public == 0 ? 'checked' : '' }} class="border border-gray-300 rounded-md p-2">
                    <label for="private">Private</label>
                </div>
                <div class="flex gap-2 items-center">
                    <input type="radio" id="public" name="is_public" value="1"
                        {{ $photo->is_public == 1 ? 'checked' : '' }} class="border border-gray-300 rounded-md p-2">
                    <label for="public">Public</label>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 w-3/4 px-4 overflow-y-auto max-h-[90vh]">
            <div class="flex flex-col gap-1">
                <label for="description">Description</label>
                <textarea required placeholder="Description" name="description" id="description" cols="30" rows="10"
                    class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none resize-none">{{ $photo->description }}</textarea>
            </div>

            <button
                class="w-1/6 bg-yellow-400 text-white p-2 rounded-md mt-4 hover:bg-yellow-500 hover:text-black transition duration-100"
                type="submit">Simpan Perubahan</button>
        </div>
    </form>

    <script>
        const tagContainer = document.getElementById('tag-container');
        const tagInput = document.getElementById('tag-input');
        const categoryError = document.getElementById('category-error');
        const imageInput = document.querySelector('input[name="image"]');
        const previewImage = document.getElementById('preview-image');

        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0];
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                const imageUrl = reader.result;
                previewImage.innerHTML =
                    `<img src="${imageUrl}" alt="Preview Image" class="w-full">`;
            });

            if (file) {
                reader.readAsDataURL(file);
            } else {
                previewImage.innerHTML = '';
            }
        });
    </script>
@endsection
